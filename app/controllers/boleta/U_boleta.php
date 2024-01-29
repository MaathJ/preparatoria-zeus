<?php 
include('../../../config/conexion.php'); 

$numero = trim($_POST['txt_nboleta']);
$codigo = $_POST['txt_id'];
$volver = $_POST['txt_volver'];

$sql ="UPDATE boleta set nroboleta_bo = $numero WHERE id_bo = $codigo";
mysqli_query($cn,$sql);

echo '<script>window.location.href = "../../../boleta.php?id=' . $volver .'";</script>';
?>