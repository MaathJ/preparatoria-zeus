<?php  

include('../config/conexion.php');

$codigo = $_POST['codalD'];

try {
    $sql_select = "SELECT nombre_al FROM alumno WHERE id_al = $codigo";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_alumno = $row['nombre_al'];

        $sql_delete = "DELETE FROM alumno WHERE id_al = '$codigo'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_student'] = "Alumno eliminado: $nombre_alumno con ID: $codigo";
    } else {
        $_SESSION['deleted_student'] = "No se pudo obtener la información del alumno con ID: $codigo";
    }
} catch (mysqli_sql_exception $e) {
    $_SESSION['error_student'] = "Error al eliminar el alumno con ID: $codigo";
}

header('location: ../alumno.php');
?>
