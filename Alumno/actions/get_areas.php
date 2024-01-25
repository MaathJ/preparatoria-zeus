
<?php
// Configuración de la conexión a la base de datos
include_once('../../config/conexion.php');

// Configurar el conjunto de caracteres a UTF-8
$cn->set_charset("utf8");

$sql = "select id_ar, nombre_ar FROM area ORDER BY nombre_ar";
$result = $cn->query($sql);


$options = array();
$options[] = array(
    'value' => '',
    'label' => '----Selecciona----'
);

while ($row = $result->fetch_assoc()) {
    $id_ar = $row['id_ar'];
    $nombre_ar = $row['nombre_ar'];

    // Agregar la opción al array
    $options[] = array(
        'value' => $id_ar,
        'label' => $nombre_ar
    );
}

// Enviar el array como respuesta JSON
echo json_encode($options);
?>
