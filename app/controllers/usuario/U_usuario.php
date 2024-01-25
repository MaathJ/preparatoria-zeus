<?php 
 include('../../../config/conexion.php');

 $id = $_POST['id_usu2'];
 $usuario = strtoupper($_POST['txtusuario']);
 $pass = strtoupper($_POST['txtpass']);
 $nombre = strtoupper($_POST['txtnombre']); 
 $apellido = strtoupper($_POST['txtapellido2']);
 $dni = $_POST['txtdni2'];
 $telefono = $_POST['txttelefono'];
 $rol = strtoupper($_POST['lstrol']);
 $estado = strtoupper($_POST['lstestado']);
 
 echo $id .' ;'. $usuario.' -'.$rol;  

 
$sql = "UPDATE  usuario set 
        usuario_us = '$usuario',
        contra_us = '$pass',
        nombre_us='$nombre',
        apellido_us='$apellido',
        dni_us='$dni',
        telefono_us='$telefono',
        estado_us='$estado',
        id_ro = '$rol'
    
        WHERE id_us = '$id'
        
        ";

mysqli_query($cn, $sql);
	
	header('location:../../../usuario.php');

?>