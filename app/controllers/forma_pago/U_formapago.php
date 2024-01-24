<?php 
include_once('../../../config/conexion.php');

$id = $_POST['txt_id'];
$nomb = $_POST['txt_nomb'];
$estado = $_POST['lst_estado'];

$nomb = strtoupper($nomb);

$sql = "UPDATE forma_pago
    SET nombre_fp = '$nomb',
    estado_fp = '$estado'
    WHERE id_fp = $id";

//ACTUALIZAR FOTO
try {
    $archivo = $_FILES['img_foto']["tmp_name"]; 
    $nombres = $_FILES['img_foto']["name"];

    if($archivo !=null){
        list($n,$e)=explode(".", $nombres);
        if ($e=="png" || $e=="jpg" || $e=="jpeg") {
            move_uploaded_file($archivo,"../../../src/assets/images/forma_pago/".$id.".jpg");
            }
    }
} catch (\Throwable $th) {}

mysqli_query($cn, $sql);

header('location: ../../../forma_pago.php');
?>