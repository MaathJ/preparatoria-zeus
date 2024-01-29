<?php 

include_once('../../../auth.php');
include_once('../../../config/conexion.php');

$idus = $_SESSION["usuario"];

$id = $_POST['u_idma'];
$ciclo = $_POST['u_lstciclo'];
$montoMa = $_POST['u_montoM'];
$desc = $_POST['u_lstdesc'];
$comentario = $_POST['u_comentario'];
$Mensualidad = $_POST['u_montoF'];
$estado =$_POST['txt_estado_edit'];

$sqlU = "UPDATE matricula SET 
        monto_ma = $montoMa,
        mensualidad_ma =$Mensualidad,
        estado_ma = '$estado',
        observacion_ma ='$comentario',
        id_ci = $ciclo,
        id_us = $idus,
        id_de = $desc
        WHERE id_ma = $id
        ";

 $up =  mysqli_query($cn,$sqlU);
  
 if ($up) {
    
    header("Location: ../../../matricula.php");

 }else{
    header("Location: ../../../matricula.php"); 
 }
  





?>