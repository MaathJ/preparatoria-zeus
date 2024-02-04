<?php

session_start();

include('../../../config/conexion.php');

$id = $_GET['id'];

try {
    $sql_select = "SELECT nombre_ca FROM carrera WHERE id_ca = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_carrera = $row['nombre_ca'];

        $sql_delete = "DELETE FROM carrera WHERE id_ca = '$id'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_carrera'] = "Carrera eliminada: $nombre_carrera con ID: $id";
    } else {
        $_SESSION['deleted_carrera'] = "No se pudo obtener la información de la carrera con ID: $id";
    }
} catch (Exception $e) {
    $_SESSION['error_carrera'] = "Error al eliminar la carrera con ID: $id";
}

header('location: ../../../carrera.php');

?>
