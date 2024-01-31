<?php


include('../../../config/conexion.php');

$id = $_GET['id'];

$sql = "DELETE FROM area WHERE id_ar = '$id'";
mysqli_query($cn, $sql);


header("Location: ../../../area.php");
?>
