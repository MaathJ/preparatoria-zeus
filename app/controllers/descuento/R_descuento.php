<?php 
include_once('../../../config/conexion.php');

$nomb = $_POST['txt_nomb'];
$monto = $_POST['txt_monto'];

$nomb = strtoupper($nomb);

$sql = "INSERT INTO descuento(nombre_de, monto_de,estado_de)
    VALUES ('$nomb',$monto, 'ACTIVO')";
mysqli_query($cn, $sql);

header('location: ../../../descuento.php');
?>