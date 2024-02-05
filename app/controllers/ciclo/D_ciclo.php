<?php
session_start();

include('../../../config/conexion.php');

$id = $_GET['id'];

// Iniciar una transacción
mysqli_begin_transaction($cn);

try {
    // Obtener el nombre del ciclo antes de eliminarlo
    $sql_select = "SELECT nombre_ci FROM ciclo WHERE id_ci = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_ciclo = $row['nombre_ci'];

        // Eliminar relaciones en detalle_ciclo_turno
        $sqlDeleteRelaciones = "DELETE FROM detalle_ciclo_turno WHERE id_ci = '$id'";
        mysqli_query($cn, $sqlDeleteRelaciones);

        // Eliminar el registro en la tabla ciclo
        $sqlDeleteCiclo = "DELETE FROM ciclo WHERE id_ci = '$id'";
        mysqli_query($cn, $sqlDeleteCiclo);

        // Confirmar la transacción
        mysqli_commit($cn);

        $_SESSION['deleted_ciclo'] = "Ciclo eliminado: $nombre_ciclo";
    } else {
        $_SESSION['deleted_ciclo'] = "No se pudo obtener la información del ciclo: $nombre_ciclo";
    }
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    mysqli_rollback($cn);

    // Manejar el error según tus necesidades
    $_SESSION['error_ciclo'] = "Matrículas existentes para $nombre_ciclo.";
}

// Cerrar la conexión
mysqli_close($cn);

// Redirigir
header("Location: ../../../ciclo.php");
exit(); // Importante salir después de redirigir para evitar ejecución adicional
?>
