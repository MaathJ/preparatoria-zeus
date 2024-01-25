<?php 
include('../../../config/conexion.php');

$codigo= $_POST['cod_rol2'];
$sql ="DELETE FROM rol WHERE id_ro =$codigo";
mysqli_query($cn,$sql);

echo '<script>window.location.href = "../../../roles.php";</script>';

?>