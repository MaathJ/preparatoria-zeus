<?php 
session_start();
include_once('../../../config/conexion.php');

$nomb = $_POST['txt_nomb'];
$monto = $_POST['txt_monto'];

$nomb = strtoupper($nomb);

$sql_select = "SELECT nombre_de FROM descuento";
$result = mysqli_query($cn, $sql_select);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['nombre_de'] === $nomb) {
            $_SESSION['alert_message'] = 'El descuento ' . $row['nombre_de'] . ' ya se encuentra registrado';
            header('location: ../../../descuento.php');
            exit();
        }
    }
}

$sql = "INSERT INTO descuento(nombre_de, monto_de, estado_de)
    VALUES (?, ?, 'ACTIVO')";
$stmt = mysqli_prepare($cn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "si", $nomb, $monto);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = 'Descuento registrado exitosamente';
    } else {
        $_SESSION['alert_message'] = 'Error al registrar el descuento';
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['alert_message'] = 'Error al preparar la consulta';
}

mysqli_close($cn);
header('location: ../../../descuento.php');
exit();
?>
