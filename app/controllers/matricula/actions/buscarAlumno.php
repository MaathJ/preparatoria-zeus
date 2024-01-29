<?php
include_once('../../../../config/conexion.php');


    $busqueda = $_POST['busqueda'];

    // Consulta SQL para buscar y mostrar todos los alumnos filtrados
    $sql = "SELECT al.id_al, al.nombre_al, al.apellido_al, al.dni_al, ar.nombre_ar, ca.nombre_ca AS nombre_ca
    FROM alumno AS al
    INNER JOIN carrera AS ca ON al.id_ca = ca.id_ca
    INNER JOIN area AS ar ON ca.id_ar = ar.id_ar
    WHERE (al.apellido_al LIKE '%$busqueda%' OR al.dni_al LIKE '%$busqueda%')
    AND al.estado_al = 'ACTIVO'";

    $resultado = $cn->query($sql);

    // Crear un HTML con la lista de alumnos
    $html = '<ul>';
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $html .= '<li>' . $fila['nombre_al'] . ' ' . $fila['apellido_al'] . ' (' . $fila['dni_al'] . ')</li>';
        }
    } else {
        $html .= '<li>No se encontraron resultados</li>';
    }
    $html .= '</ul>';

    // Devolver el HTML
    echo $html;

    // Cerrar la conexión
    $cn->close();

?>
