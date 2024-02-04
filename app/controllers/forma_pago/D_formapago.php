<?php 
session_start();
include_once('../../../config/conexion.php');

$id = $_POST['txt_id'];

try {
    $sql_select = "SELECT nombre_fp FROM forma_pago WHERE id_fp = $id";
    $result = mysqli_query($cn, $sql_select);

    $nomb = ""; // Inicializa $nomb fuera del bloque condicional

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nomb = $row['nombre_fp'];

        $sql_delete = "DELETE FROM forma_pago WHERE id_fp = '$id'";

        // ELIMINAR RUTA DE LA IMAGEN
        $ruta="../../../src/assets/images/";
        $ruta_fp=$ruta."forma_pago/".$id.".jpg";

        if (file_exists($ruta_fp)) {
            unlink($ruta_fp);
        }
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_fpago'] = "Forma de pago eliminada: $nomb";
    } else {
        $_SESSION['deleted_fpago'] = "No se pudo obtener la información de la forma de pago: $nomb";
    }
} catch (Exception $e) {
    $_SESSION['error_fpago'] = "Error al eliminar la forma de pago: $nomb.";
}

header('location: ../../../forma_pago.php');
?>
