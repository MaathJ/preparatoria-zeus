<?php 
include('../../../config/conexion.php'); 

$codigo= $_POST['codigo'];
$nombre = strtoupper($_POST['rol']);
$estado = strtoupper($_POST['lstestado']);



$sql ="UPDATE rol set nombre_ro = '$nombre', estado_ro = '$estado' WHERE id_ro =$codigo";
mysqli_query($cn,$sql);

echo '<script>window.location.href = "../../../roles.php";</script>';

?>