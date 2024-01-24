<?php 
include_once('../../../config/conexion.php');

//REGISTRO DATOS

$nomb = $_POST['txt_nomb'];

$nomb = strtoupper($nomb);

$sql = "INSERT INTO forma_pago(nombre_fp, estado_fp)
    VALUES ('$nomb','ACTIVO')";

mysqli_query($cn, $sql);

$id = mysqli_insert_id($cn);

//REGISTRO FOTO
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


header('location: ../../../forma_pago.php');
?>