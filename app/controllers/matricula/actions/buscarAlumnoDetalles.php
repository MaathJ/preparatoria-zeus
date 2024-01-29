<?php

include_once('../../../../config/conexion.php');

$dniSeleccionado = $_POST['dniSeleccionado'];

// Consulta SQL para obtener los detalles del alumno seleccionado por DNI
$sql = "SELECT al.id_al,al.nombre_al, al.apellido_al, ar.nombre_ar, ca.nombre_ca 
        FROM alumno AS al
        INNER JOIN carrera AS ca ON al.id_ca = ca.id_ca
        INNER JOIN area AS ar ON ca.id_ar = ar.id_ar
        WHERE al.dni_al = '$dniSeleccionado'";

$resultado = $cn->query($sql);

// Crear un array asociativo con los detalles del alumno
$alumnoDetalles = array();
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $alumnoDetalles['id_al'] = $fila['id_al'];
    $alumnoDetalles['nombre_al'] = $fila['nombre_al'];
    $alumnoDetalles['apellido_al'] = $fila['apellido_al'];
    $alumnoDetalles['nombre_ar'] = $fila['nombre_ar'];
    $alumnoDetalles['nombre_ca'] = $fila['nombre_ca'];
}

// Devolver los detalles del alumno como JSON
echo json_encode($alumnoDetalles);

// Cerrar la conexión
$cn->close();
?>
