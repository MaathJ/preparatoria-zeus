<?php
// Configuración de la conexión a la base de datos
include_once('../../config/conexion.php');

// Obtener el ID del área desde la solicitud POST
$idArea = $_POST['id_arU'];

$sql = "select id_ca, nombre_ca FROM carrera WHERE id_ar = $idArea";
$result = $cn->query($sql);

$options = array();
$options[] = array(
    'value' => '',
    'label' => '----Seleccionar----'
);

while ($row = $result->fetch_assoc()) {
    $id = $row['id_ca'];
    $nombre_ca = $row['nombre_ca'];

    // Agregar la opción al array
    $options[] = array(
        'value' => $id,
        'label' => $nombre_ca
    );
}

// Establecer el encabezado para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Enviar el array como respuesta JSON
echo json_encode($options);
?>