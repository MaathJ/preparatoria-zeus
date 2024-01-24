<?php
include('../../../config/conexion.php');

$id = $_POST['id_ar'];
$area = $_POST['txtarea'];
$estado = $_POST['lstestado'];



$sql = "UPDATE area SET 
        nombre_ar = '$area',
        estado_ar = '$estado'
        WHERE id_ar = '$id'";

mysqli_query($cn, $sql);
header("Location: ../../../area.php");
?>
