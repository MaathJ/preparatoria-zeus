<?php


include('../../../config/conexion.php');

$id = $_GET['id'];

try {
    $sql_select = "SELECT nombre_ar FROM area where id_ar = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_area = $row['nombre_ar'];
        $sql_delete = "DELETE FROM area WHERE id_ar = '$id'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_area'] = "Se ha eliminado la area: $nombre_area con ID: $id";
    } else {
        $_SESSION['deleted_area'] = "No se pudo obtener la información del periodo con ID: $id";
    }
} catch (Exception $e) {
    $_SESSION['error_area'] = "Error al eliminar el periodo con ID: $id";
}

header("Location: ../../../area.php");
