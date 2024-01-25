<?php 
 include('../../../config/conexion.php');

  $codigo = $_POST['cod_usu2'];

  $sql = "DELETE from usuario WHERE id_us=$codigo";
  mysqli_query($cn,$sql);

  header('location: ../../../usuario.php')
?>