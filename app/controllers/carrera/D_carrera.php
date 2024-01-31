<?php
include('../../../config/conexion.php');

$id = $_GET['id'];

$sql = "DELETE FROM carrera WHERE id_ca = '$id'";
mysqli_query($cn, $sql);

header("Location: ../../../carrera.php");
?>
