<?php 
include('../../../config/conexion.php');

$codigo = $_POST['txt_id'];
$volver = $_POST['txt_volver'];



$sqlp ="DELETE FROM pago  WHERE id_bo = $codigo";
mysqli_query($cn,$sqlp);
if ($sqlp) {

    $sql ="DELETE FROM boleta WHERE id_bo = $codigo";
    mysqli_query($cn,$sql);
    echo '<script>window.location.href = "../../../boleta.php?id=' . $volver . '";</script>';
}


echo '<script>window.location.href = "../../../boleta.php?id=' . $volver . '";</script>';
?>