<!-- Recibiendo por metodo post el formulario  -->

<?php

    if (
        isset($_POST['txtturno']) &&
        isset($_POST['txthent']) &&
        isset($_POST['txthsal']) &&
        isset($_POST['txttolerancia'])
    ) {
        $turno = $_POST['txtturno'];
        $hent = $_POST['txthent'];
        $hsal = $_POST['txthsal'];
        $tolerancia = $_POST['txttolerancia'];
        $estado = "ACTIVO";

        include('../../../config/conexion.php');

        $sql = "INSERT INTO turno (nombre_tu, hent_tu, hsal_tu, tolerancia_tu, estado_tu) VALUES ('$turno', '$hent', '$hsal', '$tolerancia', '$estado')";
        $f = mysqli_query($cn, $sql);

        if ($f) {
            // Redirigir a la misma vista con un mensaje de éxito
            header('location:../../../turno.php');
        } else {
            // Redirigir a la misma vista con un mensaje de error
            header('location:../../../turno.php');  
        }
    }
?>
