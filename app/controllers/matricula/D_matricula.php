<?php 
session_start();

include_once('../../../config/conexion.php');
$idma = $_POST['id_maD'];

try {
    $sql_eliminar_relacionados = "DELETE p, asis, b, m
                                   FROM matricula m 
                                   LEFT JOIN boleta b ON m.id_ma = b.id_ma
                                   LEFT JOIN pago p ON b.id_bo = p.id_bo
                                   LEFT JOIN asistencia asis ON m.id_ma = asis.id_ma
                                   WHERE m.id_ma = $idma";

    $result_eliminar_relacionados = mysqli_query($cn, $sql_eliminar_relacionados);

    if ($result_eliminar_relacionados) {
        $sql_delete = "DELETE FROM matricula WHERE id_ma = '$idma'";
        $result_delete = mysqli_query($cn, $sql_delete);

        if ($result_delete) {
            $_SESSION['deleted_matricula'] = "Matrícula eliminada";
        } else {
            $_SESSION['deleted_matricula'] = "Error al eliminar la matrícula";
        }
    } else {
        $_SESSION['deleted_matricula'] = "No se pudo obtener la información de la matrícula";
    }
} catch (Exception $e) {
    $_SESSION['error_matricula'] = "Error al eliminar la matrícula";
}

header('location: ../../../matricula.php');
?>
