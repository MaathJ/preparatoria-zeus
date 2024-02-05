<?php
session_start();

include('../../../config/conexion.php');

$nombre = $_POST['r_nombre'];
$fechai = $_POST['r_fechainicio'];
$fechac = $_POST['r_fechaculminacion'];
$periodo = $_POST['lstperiodo'];
$precio = $_POST['r_precio'];
$estado = 'ACTIVO';
$turno = isset($_POST['checkturno']) ? $_POST['checkturno'] : [];

$sql_select = "SELECT nombre_ci FROM ciclo";
$result = mysqli_query($cn, $sql_select);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['nombre_ci'] === $nombre) {
            $_SESSION['alert_message'] = 'El ciclo ' . $row['nombre_ci'] . ' ya se encuentra registrado';
            header('location: ../../../ciclo.php');
            exit();
        }
    }
}

// Registro del ciclo
$sqlci = "INSERT INTO ciclo (nombre_ci, fini_ci, ffin_ci, precio_ci, estado_ci, id_pe) 
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($cn, $sqlci);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssssi", $nombre, $fechai, $fechac, $precio, $estado, $periodo);

    if (mysqli_stmt_execute($stmt)) {
        // Obtener el ID del ciclo recién insertado
        $id_ciclo = mysqli_insert_id($cn);

        // Registro de los detalles del ciclo, incluyendo los turnos seleccionados
        $sqldetalle = "INSERT INTO detalle_ciclo_turno (id_ci, id_tu, estado_ct) VALUES (?, ?, ?)";
        $stmt_detalle = mysqli_prepare($cn, $sqldetalle);

        if ($stmt_detalle) {
            foreach ($turno as $id_turno) {
                mysqli_stmt_bind_param($stmt_detalle, "iis", $id_ciclo, $id_turno, $estado);
                mysqli_stmt_execute($stmt_detalle);
            }
            mysqli_stmt_close($stmt_detalle);

            $_SESSION['success_message'] = 'Ciclo registrado exitosamente';
        } else {
            $_SESSION['alert_message'] = 'Error al preparar la consulta de detalles del ciclo';
        }
    } else {
        $_SESSION['alert_message'] = 'Error al registrar el ciclo';
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['alert_message'] = 'Error al preparar la consulta de registro del ciclo';
}

mysqli_close($cn);
header('location: ../../../ciclo.php');
exit();
?>
