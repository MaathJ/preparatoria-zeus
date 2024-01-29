<?php
    include_once('../../../auth.php');
    include_once('../../../config/conexion.php');

    // Obtener los valores del formulario
    $montoM = $_POST['r_montoM'];
    $montoF = $_POST['r_montoF'];
    $estado = 'ACTIVO';
    $comentario = $_POST['r_comentario'];
    $idal = $_POST['r_idal'];
    $idci = $_POST['r_lstciclo'];
    $idus = $_SESSION["usuario"];
    $idde = $_POST['r_lstdesc'];

    // Crear la consulta SQL
    $sql = "INSERT INTO matricula (monto_ma, mensualidad_ma, estado_ma, observacion_ma, id_al, id_ci, id_us, id_de)
            VALUES ($montoM, $montoF, '$estado', '$comentario', $idal, $idci, $idus, $idde)";

    // Ejecutar la consulta
    if (mysqli_query($cn, $sql)) {
        echo "Inserción exitosa";
        header("Location: ../../../matricula.php");
    } else {
        echo "Error al insertar datos: " . mysqli_error($cn);
        header("Location: ../../../matricula.php");
    }
    echo '<script type="text/javascript">
           window.location = "../../../matricula.php";
           setTimeout(function(){
               window.location.reload(); // Esto recargará la página después de un breve retraso (en milisegundos)
           }, 1000); // Ejemplo: recarga después de 1 segundo (ajusta según sea necesario)
      </script>';
?>
