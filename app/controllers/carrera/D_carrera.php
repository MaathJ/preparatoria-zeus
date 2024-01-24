<?php
include('../../../config/conexion.php');

$codigo = $_GET['cod'];

$sql = "DELETE FROM carrera WHERE id_ca = $codigo";
mysqli_query($cn, $sql);

header("Location: ../../../carrera.php");
?>
