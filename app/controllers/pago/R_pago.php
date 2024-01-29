<?php
include('../../../config/conexion.php');

$volver=$_POST['txt_volver'];

$id = $_POST['txt_id'];
$monto = $_POST['txt_monto'];
$f_pago = $_POST['opc_fp'];

$deuda = $_POST['txt_deuda'];

$sql_pago = "insert into pago (id_pa, monto_pa,	estado_pa, id_bo, id_fp) 
                values (0, '$monto', 'ACTIVO','$id', '$f_pago')";
mysqli_query($cn, $sql_pago);

$estado_boleta = "";
if($deuda == 0){
    $estado_boleta = 'PAGADO';
}else{
    $estado_boleta = 'DEUDA';
}

$sql_boleta = "UPDATE boleta
            SET deuda_bo = $deuda,
            estadodeu_bo = '$estado_boleta'
            WHERE id_bo = $id";
mysqli_query($cn, $sql_boleta);

$ruta="location: ../../../boleta.php?id=".$volver;
header($ruta);
?>