<?php  

include('../config/conexion.php');

$codigo = $_POST['codalD'];

$sql = "delete from alumno  WHERE id_al = $codigo";


mysqli_query($cn, $sql);
	
	header('location: ../alumno.php');


?>