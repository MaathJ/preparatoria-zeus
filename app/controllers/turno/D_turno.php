<?php
include('../../../config/conexion.php');

$codigo = $_GET['cod'];

$sql = "DELETE FROM turno WHERE id_tu = $codigo";
mysqli_query($cn, $sql);

header('location:../../../turno.php');
?>
