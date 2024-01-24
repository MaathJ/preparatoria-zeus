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
            $_SESSION['alert_message'] = 'El periodo ' .$row['nombre_pe'] . ' ya se encuentra registrado';
            header('location: ../../../periodo.php');
            exit();
        }
    }
}
$sql = "INSERT INTO periodo(nombre_pe, estado_pe) VALUES ('$nombre_periodo', '$estado_periodo')";
$r = mysqli_query($cn, $sql);

header('location: ../../../periodo.php');
?>
