<?php 
include_once('../../../config/conexion.php');

$id = $_POST['txt_id'];
$nomb = $_POST['txt_nomb'];
$monto = $_POST['txt_monto'];
$estado = $_POST['lst_estado'];

$nomb = strtoupper($nomb);

$sql = "UPDATE descuento
    SET nombre_de = '$nomb',
    monto_de = $monto,
    estado_de = '$estado'
    WHERE id_de = $id";
mysqli_query($cn, $sql);

header('location: ../../../descuento.php');
?>