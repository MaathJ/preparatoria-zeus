<?php
include('../../../config/conexion.php');

$id = $_POST['id_tu'];
$turno = $_POST['txtturno'];
$hent = $_POST['txthent'];
$hsal = $_POST['txthsal'];
$tolerancia = $_POST['txttolerancia'];
$estado = $_POST['lstestado'];

echo $id . ' ;' . $turno;

$sql = "UPDATE turno SET 
        nombre_tu = '$turno',
        hent_tu = '$hent',
        hsal_tu = '$hsal',
        tolerancia_tu = '$tolerancia',
        estado_tu = '$estado'
        WHERE id_tu = '$id'";

mysqli_query($cn, $sql);

header('location:../../../turno.php');
?>
