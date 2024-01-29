<?php 
include('../../../config/conexion.php');

$codigo= $_POST['cod_pa'];
$sql ="DELETE FROM pago WHERE id_pa =$codigo";
mysqli_query($cn,$sql);

echo '<script>window.location.href = "../../../boleta.php?id=1";</script>';

?>