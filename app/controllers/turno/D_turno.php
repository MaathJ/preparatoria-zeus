<?php
session_start();

include('../../../config/conexion.php');

$id = $_GET['id'];

try {
    $sql_select = "SELECT nombre_tu FROM turno WHERE id_tu = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_turno = $row['nombre_tu'];

        $sql_delete = "DELETE FROM turno WHERE id_tu = '$id'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_turn'] = "Turno $nombre_turno  ha sido eliminado, con ID: $id";
    } else {
        $_SESSION['deleted_turn'] = "No se pudo obtener la información del turno con ID: $id";
    }
} catch (Exception $e) {
    $_SESSION['error_turn'] = "Error al eliminar el turno: $nombre_turno, con ID: $id";
}

header('location: ../../../turno.php');
?>
