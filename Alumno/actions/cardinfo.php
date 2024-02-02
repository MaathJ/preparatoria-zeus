<?php
// Configuración de la conexión a la base de datos
include_once('../../config/conexion.php');

// Obtener el ID del área desde la solicitud POST
$cn->set_charset("utf8");
$idAlumno = $_POST['id_alI'];

$sql = "SELECT * FROM alumno WHERE id_al = $idAlumno";
$result = $cn->query($sql);

// Verificar si se encontró un registro
if ($row = $result->fetch_assoc()) {
    $nombre_al = $row['nombre_al'] . ', ' . $row['apellido_al'];
    $fechaNacimiento = $row['fnac_al'];
    // Obtener la fecha actual
    $fechaActual = date('Y-m-d');
    // Calcular la diferencia entre la fecha actual y la fecha de nacimiento
    $diff = date_diff(date_create($fechaNacimiento), date_create($fechaActual));
    // Obtener el componente de años de la diferencia
    $edad = $diff->format('%Y') . ' años';
    $id_carrera=$row['id_ca'];
    $subc="Select nombre_ar,nombre_ca from alumno a inner join carrera c ON c.id_ca=a.id_ca
            inner join area ar on ar.id_ar=c.id_ar where a.id_ca=$id_carrera";
            $result=mysqli_query($cn,$subc);
            if ($result) {
                // Obtenemos la primera fila del resultado
                $rows = mysqli_fetch_assoc($result);
            
                // Extraemos los valores de las columnas nombre_ar y nombre_ca
                $nombre_ar = $rows['nombre_ar'];
                $nombre_ca = $rows['nombre_ca'];
            };
    // Construir el único arreglo asociativo con la información
    $info = array(
        'nombre' => $nombre_al,
        'edad' => $edad,
        'estado' => $row['estado_al'],
        'dni' => $row['dni_al'],
        'telefono' => $row['celular_al'],
        'fechaNacimiento' => $row['fnac_al'],
        'direccion' => $row['direccion_al'],
        'ciudad' => $row['ciudadp_al'],
        'colegio' => $row['colegio_al'],
        'universidad' => $row['uni_al'],
        'apoderado' => $row['apoderado_al'],
        'telefonoApoderado' => $row['celapod_al'],
        'nombre_carrera' => $nombre_ca,
        'nombre_area' => $nombre_ar
    );

    // Enviar el arreglo como respuesta JSON
    echo json_encode($info);
} else {
    // Si no se encontró ningún registro, puedes manejar la respuesta de alguna manera
    echo json_encode(array('error' => 'No se encontró el registro'));
}
?>
