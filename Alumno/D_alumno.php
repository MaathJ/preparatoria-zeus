<?php  

include('../config/conexion.php');

$codigo = $_POST['codalD'];

$sql = "update alumno SET estado_al = 'INACTIVO' WHERE id_al = $codigo";


mysqli_query($cn, $sql);
	
	header('location: ../alumno.php');


?>