<?php
include_once('../../config/conexion.php');

$dni = $_POST['dni'];

// Llamada al procedimiento almacenado
$sql = "CALL BuscarAlumnoPorDNI('$dni', @p_existe)";
$cn->query($sql);

// Obtener el resultado del procedimiento almacenado
$sql = "SELECT @p_existe AS p_existe";
$result = $cn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $existe = $row['p_existe'];

    // Devuelve la respuesta al cliente
    if ($existe == 1) {
        echo "existe";
    } else {
        echo "no_existe";
    }
} else {
    // Manejar errores si es necesario
    echo "error";
}
?>
