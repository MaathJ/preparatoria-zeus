<?php


include('../../../config/conexion.php');

$nombre = $_POST['r_nombre'];
$fechai = $_POST['r_fechainicio'];
$fechac = $_POST['r_fechaculminacion'];
$periodo = $_POST['lstperiodo'];
$precio = $_POST['r_precio'];
$estado = 'ACTIVO';
$turno = isset($_POST['checkturno']) ? $_POST['checkturno'] : [];



// Registro del ciclo
$sqlci = "INSERT INTO ciclo (nombre_ci , fini_ci , ffin_ci,precio_ci , estado_ci ,id_pe) 
        VALUE ('$nombre','$fechai' , '$fechac' ,$precio, '$estado' ,$periodo)";
$fci = mysqli_query($cn, $sqlci);

if ($fci) {
    // Obtener el ID del ciclo recién insertado
    $id_ciclo = mysqli_insert_id($cn);

    // Registro de los detalles del ciclo, incluyendo los turnos seleccionados
    foreach ($turno as $id_turno) {
        $sqldetalle = "INSERT INTO detalle_ciclo_turno (id_ci , id_tu, estado_ct) 
                       VALUES ($id_ciclo, $id_turno, '$estado')";
        $fdetalle = mysqli_query($cn, $sqldetalle);
    }

    if ($fdetalle) {
        echo "Ciclo y detalles registrados correctamente.";
        header("Location: ../../../ciclo.php");
        
    } else {
        echo "Error al registrar detalles del ciclo: " . mysqli_error($cn);
        header("Location: ../../../ciclo.php");
    }
} else {
    echo "Error al registrar el ciclo: " . mysqli_error($cn);
}

mysqli_close($cn);
?>
