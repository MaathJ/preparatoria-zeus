<?php 

include('../../../config/conexion.php');

$codigo = $_GET['cod'];

// Iniciar una transacción
mysqli_begin_transaction($cn);

try {
    // Eliminar relaciones en detalle_ciclo_turno
    $sqlDeleteRelaciones = "DELETE FROM detalle_ciclo_turno WHERE id_ci = $codigo";
    mysqli_query($cn, $sqlDeleteRelaciones);

    // Eliminar el registro en la tabla ciclo
    $sqlDeleteCiclo = "DELETE FROM ciclo WHERE id_ci = $codigo";
    mysqli_query($cn, $sqlDeleteCiclo);

    // Confirmar la transacción
    mysqli_commit($cn);

    echo "Eliminación exitosa";

    header("Location: ../../../ciclo.php");



} catch (Exception $e) {
    // Revertir la transacción en caso de error
    mysqli_rollback($cn);

    // Manejar el error según tus necesidades
    echo "Error en la eliminación: " . $e->getMessage();
}

// Cerrar la conexión
mysqli_close($cn);
?>

