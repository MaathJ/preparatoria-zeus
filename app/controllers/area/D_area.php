<?php


include('../../../config/conexion.php');

$codigo = $_GET['cod'];

$sql = "DELETE FROM area WHERE id_ar = $codigo";
mysqli_query($cn, $sql);


header("Location: ../../../area.php");
?>
