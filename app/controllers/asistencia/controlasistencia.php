<?php
include('../../../config/conexion.php');

// Obtener el DNI del formulario POST
$dniAlumno = $_POST['dni'];

// Arreglo para almacenar los resultados
$resultados = array();

// Verificar si el DNI del alumno existe
$consultaExistencia = "SELECT COUNT(*) as total FROM alumno WHERE dni_al = '$dniAlumno'";
$resultadoExistencia = mysqli_query($cn, $consultaExistencia);

if ($resultadoExistencia) {
    $filaExistencia = mysqli_fetch_assoc($resultadoExistencia);
    $totalAlumnos = $filaExistencia['total'];

    // //Si en caso existe (Escenario 1)
    if ($totalAlumnos == 1) {
        // El DNI del alumno existe, continuar con las consultas originales
        // Obtener la fecha y hora actual en la zona horaria de Lima
        date_default_timezone_set('America/Lima');
        $fechaHoraActual = date('Y-m-d H:i:s');
        // Consulta para obtener las matrículas del alumno y verificar el rango de hora
        $consulta = "
            SELECT 
                m.*,
                dt.id_tu,
                t.hent_tu,
                t.hsal_tu,
                t.tolerancia_tu
            FROM 
                matricula m
            INNER JOIN 
                detalle_ciclo_turno dt ON m.id_ci = dt.id_ci
            INNER JOIN 
                turno t ON dt.id_tu = t.id_tu
            INNER JOIN 
                alumno a ON a.id_al = m.id_al
            WHERE 
                a.dni_al = '$dniAlumno' AND
                '$fechaHoraActual' BETWEEN CONCAT(CURRENT_DATE, ' ', t.hent_tu) AND CONCAT(CURRENT_DATE, ' ', t.hsal_tu)
        ";

        $resultado = mysqli_query($cn, $consulta);

        if ($resultado) {

                $filama = mysqli_fetch_assoc($resultado); 
                // Matrícula encontrada dentro del rango
                $idMatricula = $filama['id_ma'];
                $idTurno = $filama['id_tu'];
                $hentTu = $filama['hent_tu'];
                $hsalTu = $filama['hsal_tu'];
                $tolerancia = $filama['tolerancia_tu'];
                mysqli_free_result($resultado);

                $sqlboleta="SELECT * from boleta where id_ma=$idMatricula and estadodur_bo='ACTIVO'";
                $rsqlb=mysqli_query($cn,$sqlboleta);
                $filasqlb = mysqli_fetch_assoc($rsqlb);

                if($filasqlb){

                    $sqldeuda = "SELECT deuda_bo FROM boleta WHERE id_ma = $idMatricula AND estadodur_bo = 'ACTIVO' LIMIT 1";
                    $rsqld = mysqli_query($cn, $sqldeuda);

                    // Verificar si se obtuvieron resultados
                    if ($rsqld) {
                        // Obtener la fila como un array asociativo
                        $fila = mysqli_fetch_assoc($rsqld);

                        // Verificar si se encontró algún resultado
                        if ($fila) {
                            // Asignar el valor de deuda_bo a la variable $deuda
                            $deuda = $fila['deuda_bo'];
                            // Liberar la memoria asociada con el conjunto de resultados
                            mysqli_free_result($rsqld);
                        } else {
                            // No se encontraron resultados
                            $deuda = "No hay deuda registrada";
                        }
                    } 

                    $toleranciaMinutos = $tolerancia;
                    $horaActual = date('H:i:s'); // Cambia esta línea según la hora que desees probar


                    // Convertir la hora de inicio y fin del turno a formato de hora
                    $hentTuHoraFormato = date('H:i:s', strtotime($hentTu));
                    $hsalTuHoraFormato = date('H:i:s', strtotime($hsalTu));

                    if ($hentTuHoraFormato === false || $hsalTuHoraFormato === false) {
                        // Manejar el error si la conversión de hora falla
                        die('Error al convertir las horas.');
                    }

                    // Sumar la tolerancia a la hora de inicio
                    $hentTuHoraFormatoConTolerancia = date('H:i:s', strtotime($hentTuHoraFormato . " +$toleranciaMinutos minutes"));

                    // Obtener la hora de fin con tolerancia adicional (45 minutos)
                    $hsalTuTardanzaHoraFormato = date('H:i:s', strtotime($hentTuHoraFormatoConTolerancia . " +45 minutes"));

                    // Comparar la hora actual con la hora de inicio y fin del turno
                    if ($horaActual >= $hentTuHoraFormato && $horaActual <= $hentTuHoraFormatoConTolerancia) {
                        $estado_Asistencia = 'ASISTIO';
                    } elseif ($horaActual > $hentTuHoraFormatoConTolerancia && $horaActual <= $hsalTuTardanzaHoraFormato) {
                        // El estudiante llega dentro del rango de asistencia con tolerancia (tardanza)
                        $estado_Asistencia = 'TARDANZA';
                    } else {
                        $estado_Asistencia = 'FALTA';
                    }


                    // Agregar resultado al arreglo
                    $resultados[] = array(
                        'escenario' => 4,
                        'mensaje' => "La matrícula con ID $idMatricula está dentro del rango del turno. $hentTu - $hsalTu - Hora actual: $horaActual",
                        'estadoa' => $estado_Asistencia,
                        'idma' => $idMatricula,
                        'deuda' => $deuda,
                        'TARD' => $hentTuHoraFormatoConTolerancia,
                        'TARDF' => $hsalTuTardanzaHoraFormato,
                        'INI' => $hentTuHoraFormato,
                        'FIN' => $hsalTuHoraFormato,

                    );
                    $sqlinsertasistencia = "INSERT INTO asistencia (id_ma, estado_as) VALUES (?, ?)";

                    // Preparar la consulta
                    $stmt = mysqli_prepare($cn, $sqlinsertasistencia);

                    if ($stmt) {
                        // Vincular parámetros
                        mysqli_stmt_bind_param($stmt, 'is', $idMatricula, $estado_Asistencia);

                        // Ejecutar la consulta
                        $successqlinsertarasistencia = mysqli_stmt_execute($stmt);
                        // Cerrar la declaración
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "Error al preparar la consulta: " . mysqli_error($cn);
                    }





                }else{
                    $resultados[] = array(
                        'escenario' => 3,
                        'mensaje' => "El alumno no tiene ninguna boleta actualmente activa" 
                    );
                }
                // La hora actual no está dentro del rango de ningún turno
                // Consultar el turno más cercano
                // $consultaCercano = "
                //     SELECT 
                //         m.*,
                //         dt.id_tu,
                //         t.hent_tu,
                //         t.hsal_tu
                //     FROM 
                //         matricula m
                //     INNER JOIN 
                //         detalle_ciclo_turno dt ON m.id_ci = dt.id_ci
                //     INNER JOIN 
                //         turno t ON dt.id_tu = t.id_tu
                //     INNER JOIN 
                //         alumno a ON a.id_al = m.id_al
                //     WHERE 
                //         a.dni_al = '$dniAlumno'
                //     ORDER BY 
                //         ABS(TIMESTAMPDIFF(SECOND, '$fechaHoraActual', CONCAT(CURRENT_DATE, ' ', t.hent_tu)))
                //     LIMIT 1
                // ";

                // $resultadoCercano = mysqli_query($cn, $consultaCercano);

                // if ($filaCercano = mysqli_fetch_assoc($resultadoCercano)) {
                //     // Matrícula encontrada para el turno más cercano
                //     $idMatriculaCercano = $filaCercano['id_ma'];
                //     $idTurnoCercano = $filaCercano['id_tu'];
                //     $hentTuCercano = $filaCercano['hent_tu'];
                //     $hsalTuCercano = $filaCercano['hsal_tu'];

                //     // Agregar resultado al arreglo
                //     $resultados[] = array(
                //         'escenario' => 2,
                //         'mensaje' => "La matrícula con ID $idMatriculaCercano está más cercana al turno. $hentTuCercano - $hsalTuCercano - Hora actual: $fechaHoraActual"
                //     );
                // } else {
                //     // No se encontraron matrículas para el turno más cercano
                //     // Agregar resultado al arreglo
                //     $resultados[] = array(
                //         'escenario' => 3,
                //         'mensaje' => "No se encontraron matrículas para el turno más cercano."
                //     );
                // }

                // // Liberar memoria después de la consulta de cercano
                // mysqli_free_result($resultadoCercano);

            // Liberar memoria después de la consulta
        } else {
            // Manejar el error en la consulta si es necesario
            $resultados[] = array(
                'escenario' => 2,
                'mensaje' => "El alumno no está matriculado o está fuera de su horario" 
            );
        }
    } else {
        // El DNI del alumno no existe en la base de datos
        $resultados[] = array(
            'escenario' => 1,
            'mensaje' => "No existe un alumno con el DNI proporcionado."
        );
    }

    // Liberar memoria después de la consulta de existencia
    mysqli_free_result($resultadoExistencia);
} /* else {
    // Manejar el error en la consulta de existencia si es necesario
    $resultados[] = array(
        'escenario' => 1,
        'mensaje' => "Error en la consulta de existencia: " . mysqli_error($cn)
    );
} */


// Convertir el arreglo a formato JSON y enviarlo como respuesta
echo json_encode($resultados);
?>