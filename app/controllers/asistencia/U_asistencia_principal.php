<?php 
include('../../../config/conexion.php');

$id = $_POST['u_cod'] ;
$estado = $_POST['u_lstestado'] ;


echo $id .' '.$estado;




        $sql = "UPDATE asistencia SET 
                estado_as = '$estado'
                WHERE id_as = $id ";

mysqli_query($cn, $sql);


header("Location: ../../../principal.php");

?>