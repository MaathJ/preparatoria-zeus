<?php 
include_once('../../../config/conexion.php');

$id = $_POST['txt_id'];

$nomb = strtoupper($nomb);

$sql = "DELETE FROM forma_pago
    WHERE id_fp = $id";

//ELIMINAR RUTA DE LA IMAGEN
$ruta="../../../src/assets/images/";
$ruta_fp=$ruta."forma_pago/".$id.".jpg";

if (file_exists($ruta_fp)) {
    unlink($ruta_fp);
}

mysqli_query($cn, $sql);

header('location: ../../../forma_pago.php');
?>