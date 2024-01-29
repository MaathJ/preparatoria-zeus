<?php
include_once('../../../../config/conexion.php');

// Verificar si se recibió un ID de descuento válido
if(isset($_POST['id_des']) && !empty($_POST['id_des'])) {
    // Obtener el ID del área desde la solicitud POST y escapar para prevenir inyección SQL
    $id_desc = mysqli_real_escape_string($cn, $_POST['id_des']);

    // Realizar la consulta SQL para obtener el precio_de
    $sqlPrecio = "SELECT monto_de FROM descuento WHERE id_de = $id_desc";
    $resultadoPrecio = mysqli_query($cn, $sqlPrecio);

    // Verificar si la consulta fue exitosa
    if ($resultadoPrecio) {
        // Verificar si se encontraron resultados
        if(mysqli_num_rows($resultadoPrecio) > 0) {
            // Obtener el precio_de (suponiendo que es un valor único)
            $filaPrecio = mysqli_fetch_assoc($resultadoPrecio);
            $precioCi = $filaPrecio['monto_de'];

            // Preparar el arreglo de datos
            $datos['precio_de'] = $precioCi;

            // Establecer el encabezado para indicar que la respuesta es JSON
            header('Content-Type: application/json');

            // Enviar el arreglo como respuesta JSON
            echo json_encode($datos);
        } else {
            echo "No se encontraron resultados para el ID de descuento proporcionado.";
        }
    } else {
        // Manejar el caso de error en la consulta de precio_de
        echo "Error en la consulta de precio_de: " . mysqli_error($cn);
    }
} else {
    echo "No se proporcionó un ID de descuento válido.";
}
?>
