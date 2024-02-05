<?php
session_start();

include_once('../../../config/conexion.php');

$nombre_periodo = $_POST['txt_periodo'];
$estado_periodo = 'ACTIVO';

$sql_select = "SELECT nombre_pe FROM periodo";
$result = mysqli_query($cn, $sql_select);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['nombre_pe'] === $nombre_periodo) {
            $_SESSION['alert_message'] = 'El periodo ' . $row['nombre_pe'] . ' ya se encuentra registrado';
            header('location: ../../../periodo.php');
            exit();
        }
    }
}

$sql = "INSERT INTO periodo(nombre_pe, estado_pe) VALUES (?, ?)";
$stmt = mysqli_prepare($cn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $nombre_periodo, $estado_periodo);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = 'Periodo registrado exitosamente';
    } else {
        $_SESSION['alert_message'] = 'Error al registrar el periodo';
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['alert_message'] = 'Error al preparar la consulta';
}

mysqli_close($cn);
header('location: ../../../periodo.php');
exit();
?>
