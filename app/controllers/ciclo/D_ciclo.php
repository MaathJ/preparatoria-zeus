<?php
include('../../../config/conexion.php');

$id = $_GET['id'];

// Iniciar una transacción
mysqli_begin_transaction($cn);

try {
    // Eliminar relaciones en detalle_ciclo_turno
    $sqlDeleteRelaciones = "DELETE FROM detalle_ciclo_turno WHERE id_ci = '$id'";
    mysqli_query($cn, $sqlDeleteRelaciones);

    // Eliminar el registro en la tabla ciclo
    $sqlDeleteCiclo = "DELETE FROM ciclo WHERE id_ci = '$id'";
    mysqli_query($cn, $sqlDeleteCiclo);

    // Confirmar la transacción
    mysqli_commit($cn);

    // Redireccionar después de completar las operaciones
    header("Location: ../../../ciclo.php");
    exit(); // Asegurarse de que el script se detenga después de la redirección

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    mysqli_rollback($cn);

    // Manejar el error según tus necesidades
    echo "Error en la eliminación: " . $e->getMessage();
    header("Location: ../../../ciclo.php");
}

// Cerrar la conexión
mysqli_close($cn);
?>

