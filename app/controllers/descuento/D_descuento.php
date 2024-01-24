<?php 
include_once('../../../config/conexion.php');

$id = $_POST['txt_id'];

$sql = "DELETE FROM descuento
    WHERE id_de = $id";
mysqli_query($cn, $sql);

header('location: ../../../descuento.php');
?>