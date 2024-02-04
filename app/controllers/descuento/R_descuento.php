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
            $_SESSION['alert_message'] = 'El descuento ' .$row['nombre_de'] . ' ya se encuentra registrado';
            header('location: ../../../descuento.php');
            exit();
        }
    }
}

$sql = "INSERT INTO descuento(nombre_de, monto_de,estado_de)
    VALUES ('$nomb',$monto, 'ACTIVO')";
mysqli_query($cn, $sql);

header('location: ../../../descuento.php');
?>