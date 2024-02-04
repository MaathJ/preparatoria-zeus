<?php 
session_start();
include_once('../../../config/conexion.php');

$id = $_POST['txt_id'];

try {
    $sql_select = "SELECT nombre_de FROM descuento WHERE id_de = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_dcto = $row['nombre_de'];

        $sql_delete = "DELETE FROM descuento WHERE id_de = '$id'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_descuento'] = "Descuento eliminado: $nombre_dcto";
    } else {
        $_SESSION['deleted_descuento'] = "No se pudo obtener la información del descuento $nombre_dcto";
    }
} catch (Exception $e) {
    $_SESSION['error_descuento'] = "Alumnos existentes con el descuento $nombre_dcto";
}

header('location: ../../../descuento.php');
?>