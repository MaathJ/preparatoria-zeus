<?php
include('../../../config/conexion.php');

$id = $_POST['id_ca'] ;
$carrera = $_POST['txtcarrera'] ;
$area =  $_POST['lstarea'] ;
$estado= $_POST['lstestado'] ;



        $sql = "UPDATE carrera SET 
                nombre_ca = '$carrera',
                estado_ca='$estado',
                id_ar=$area
               

                WHERE id_ca = $id";

mysqli_query($cn, $sql);


header("Location: ../../../carrera.php");



?>
