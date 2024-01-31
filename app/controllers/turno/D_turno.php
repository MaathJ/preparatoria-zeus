<?php
include('../../../config/conexion.php');

$id = $_GET['id'];

$sql = "DELETE FROM turno WHERE id_tu = '$id'";
mysqli_query($cn, $sql);

header('location:../../../turno.php');
?>
