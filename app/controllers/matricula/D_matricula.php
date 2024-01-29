<?php 
    include_once('../../../config/conexion.php');
    $idma=$_POST['id_maD'];
    $sql = "delete from matricula where id_ma=$idma";

    // Ejecutar la consulta
    if (mysqli_query($cn, $sql)) {
        echo "Eliminación exitosa";
        header("Location: ../../../matricula.php");
    } else {
        echo "Error al eliminar datos: " . mysqli_error($cn);
        header("Location: ../../../matricula.php");
    }
    echo '<script type="text/javascript">
           window.location = "../../../matricula.php";
           setTimeout(function(){
               window.location.reload(); // Esto recargará la página después de un breve retraso (en milisegundos)
           }, 1000); // Ejemplo: recarga después de 1 segundo (ajusta según sea necesario)
      </script>';
?>