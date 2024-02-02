<?php
include('config/conexion.php');

// Obtener la fecha actual
$fecha_actual = date('Y-m-d');

// Consultar ciclos que han culminado
$sql_ciclos_culminados = "SELECT * FROM ciclo WHERE ffin_ci <= '$fecha_actual' AND estado_ci = 'ACTIVO'";
$result_ciclos = mysqli_query($cn, $sql_ciclos_culminados);

echo $fecha_actual;
// Recorrer los ciclos culminados
while ($ciclo = mysqli_fetch_assoc($result_ciclos)) {
    $id_ciclo = $ciclo['id_ci'];

    echo "Nombre del ciclo: " . $ciclo['nombre_ci'] . "<br>";
    echo "Fecha de inicio: " . $ciclo['fini_ci'] . "<br>";
    echo "Fecha de finalización: " . $ciclo['ffin_ci'] . "<br>";
    echo "<hr>";

    // Eliminar registros relacionados en las tablas alumno, boleta, pago, asistencia
    $sql_eliminar_relacionados = "DELETE p, asis, b, m, a
                               FROM alumno a
                               LEFT JOIN matricula m ON a.id_al = m.id_al
                               LEFT JOIN boleta b ON m.id_ma = b.id_ma
                               LEFT JOIN pago p ON b.id_bo = p.id_bo
                               LEFT JOIN asistencia asis ON m.id_ma = asis.id_ma
                               WHERE m.id_ci = $id_ciclo";

    mysqli_query($cn, $sql_eliminar_relacionados);

    // // Eliminar registros de la tabla matricula
    // $sql_eliminar_matricula = "DELETE FROM matricula WHERE id_ci = $id_ciclo";
    // mysqli_query($cn, $sql_eliminar_matricula);

    // Actualizar estado del ciclo a "INACTIVO"
    $sql_actualizar_estado = "UPDATE ciclo SET estado_ci = 'INACTIVO' WHERE id_ci = $id_ciclo";
    mysqli_query($cn, $sql_actualizar_estado);
}

// Cerrar conexión a la base de datos
mysqli_close($cn);
?>