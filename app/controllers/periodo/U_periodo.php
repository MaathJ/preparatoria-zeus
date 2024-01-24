<?php
include_once('../../../config/conexion.php');
$id = $_POST['txt_id_periodo'];
$nombre_periodo = $_POST['txt_periodo'];
$estado_periodo = $_POST['txt_estado_edit'];

$sql = "UPDATE periodo SET
    nombre_pe = '$nombre_periodo',
    estado_pe = '$estado_periodo'
    WHERE id_pe = '$id'
";
mysqli_query($cn, $sql);
	
header('location: ../../../periodo.php');
?>