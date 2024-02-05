<?php
session_start();

include('../../../config/conexion.php');

if (isset($_POST['txtarea'])) {
    $area = $_POST['txtarea'];
    // $estado = $_POST['lstestado'];

    if (isset($_POST['txtarea'])) {

        $area = $_POST['txtarea'];
    
        $sql_select = "SELECT nombre_ar FROM area";
        $result = mysqli_query($cn, $sql_select);
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['nombre_ar'] === $area) {
                    $_SESSION['alert_message'] = 'El Área ' . $row['nombre_ar'] . ' ya se encuentra registrada';
                    header('location: ../../../area.php');
                    exit();
                }
            }
        }
        

    // ...

$sql = "INSERT INTO area (nombre_ar, estado_ar) VALUES (?, 'ACTIVO')";
$f = mysqli_prepare($cn, $sql);  // Cambia mysqli_query a mysqli_prepare

if ($f) {
    mysqli_stmt_bind_param($f, "s", $area);  // Elimina el primer argumento y ajusta el tipo de dato a "s"

    if (mysqli_stmt_execute($f)) {
        $_SESSION['success_message'] = 'Área registrada exitosamente';
    } else {
        $_SESSION['alert_message'] = 'Error al registrar el área';
    }

    mysqli_stmt_close($f);
} else {
    $_SESSION['alert_message'] = 'Error al preparar la consulta';
}

    header('location: ../../../area.php');
    exit();
}
}
?>