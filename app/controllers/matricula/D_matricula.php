<?php 
    include_once('../../../config/conexion.php');
    $idma=$_POST['id_maD'];

    $sql_eliminar_relacionados = "DELETE p, asis, b, m
   
    FROM matricula m 
    LEFT JOIN boleta b ON m.id_ma = b.id_ma
    LEFT JOIN pago p ON b.id_bo = p.id_bo
    LEFT JOIN asistencia asis ON m.id_ma = asis.id_ma
    WHERE m.id_ma = $idma";

    
 $fdelete=mysqli_query($cn, $sql_eliminar_relacionados);
    // Ejecutar la consulta
    if ($fdelete) {

        
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