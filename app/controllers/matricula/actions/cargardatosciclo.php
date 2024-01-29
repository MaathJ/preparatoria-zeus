<?php 
include_once('../../../../config/conexion.php');

// Verificar si se recibió un ID de ciclo válido
if(isset($_POST['id_Ciclo']) && !empty($_POST['id_Ciclo'])) {
    // Obtener el ID del ciclo desde la solicitud POST y escapar para prevenir inyección SQL
    $idCiclo = mysqli_real_escape_string($cn, $_POST['id_Ciclo']);

    // Realizar la consulta SQL para obtener el precio_ci
    $sqlPrecio = "SELECT precio_ci FROM ciclo WHERE id_ci = ?";
    $stmtPrecio = mysqli_prepare($cn, $sqlPrecio);
    mysqli_stmt_bind_param($stmtPrecio, "i", $idCiclo);
    mysqli_stmt_execute($stmtPrecio);
    $resultadoPrecio = mysqli_stmt_get_result($stmtPrecio);

    // Verificar si la consulta fue exitosa
    if ($resultadoPrecio) {
        // Obtener el precio_ci (suponiendo que es un valor único)
        $filaPrecio = mysqli_fetch_assoc($resultadoPrecio);
        $precioCi = $filaPrecio['precio_ci'];

        // Realizar la consulta SQL con JOIN para obtener los turnos
        $sqlTurnos = "SELECT t.id_tu, t.nombre_tu, t.hent_tu, t.hsal_tu, t.tolerancia_tu
        FROM turno t
        INNER JOIN detalle_ciclo_turno dc ON t.id_tu = dc.id_tu
        WHERE dc.id_ci = ?";
        $stmtTurnos = mysqli_prepare($cn, $sqlTurnos);
        mysqli_stmt_bind_param($stmtTurnos, "i", $idCiclo);
        mysqli_stmt_execute($stmtTurnos);
        $resultadoTurnos = mysqli_stmt_get_result($stmtTurnos);

        if ($resultadoTurnos) {
            // Construir un arreglo para almacenar los resultados
            $datos = array();

            // Inicializar un array para almacenar los turnos
            $turnos = array();

            // Recorrer los resultados y agregarlos al arreglo
            while ($filaTurno = mysqli_fetch_assoc($resultadoTurnos)) {
                $nombreTurno = $filaTurno['nombre_tu'];
                $horarioTurno = $filaTurno['hent_tu'] . "-" . $filaTurno['hsal_tu'];

                // Concatenar los datos y agregarlos al arreglo de turnos
                $turnos[] = $nombreTurno . "/".$horarioTurno;
            }

            // Agregar el arreglo de turnos al arreglo principal
            $datos['turno_ci'] = $turnos;

            // Agregar el precio_ci al arreglo
            $datos['precio_ci'] = $precioCi;

            // Establecer el encabezado para indicar que la respuesta es JSON
            header('Content-Type: application/json');

            // Enviar el arreglo como respuesta JSON
            echo json_encode($datos);
        } else {
            // Manejar el caso de error en la consulta de turnos
            echo "Error en la consulta de turnos: " . mysqli_error($cn);
        }
    } else {
        // Manejar el caso de error en la consulta de precio_ci
        echo "Error en la consulta de precio_ci: " . mysqli_error($cn);
    }
} else {
    echo "No se proporcionó un ID de ciclo válido.";
}
?>
