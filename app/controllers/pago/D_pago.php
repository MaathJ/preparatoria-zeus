<?php 
include('../../../config/conexion.php');

$codigo= $_POST['cod_pa'];
$boleta= $_POST['cod_bo'];
$volver= $_POST['volver'];

$sql_deuda = "SELECT monto_pa AS total FROM pago WHERE id_pa = $codigo";
$f_deuda = mysqli_query($cn, $sql_deuda);
$r_deuda = mysqli_fetch_assoc($f_deuda);

$sql_monto = "SELECT deuda_bo AS deuda FROM boleta WHERE id_bo = $boleta";
$f_monto = mysqli_query($cn, $sql_monto);
$r_monto = mysqli_fetch_assoc($f_monto);

$suma = $r_deuda['total'];
$monto = $r_monto['deuda'];

$total = $suma + $monto;

$sql ="DELETE FROM pago WHERE id_pa =$codigo";
mysqli_query($cn,$sql);

$sql2 = "UPDATE boleta
    SET deuda_bo = $total,
    estadodeu_bo = 'DEUDA'
    WHERE id_bo = $boleta";

mysqli_query($cn, $sql2);

echo '<script>window.location.href = "../../../boleta.php?id='.$volver.'";</script>';
?>