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

    $sql_ciclo = "SELECT COUNT(c.nombre_ci) AS total_ciclo 
                    FROM ciclo c
                    INNER JOIN detalle_ciclo_turno dt ON c.id_ci = dt.id_ci
                    INNER JOIN turno t ON dt.id_tu = t.id_tu 
                    WHERE CURRENT_DATE BETWEEN c.fini_ci AND c.ffin_ci
                    AND NOW() BETWEEN CONCAT(CURRENT_DATE, ' ', t.hent_tu) AND CONCAT(CURRENT_DATE, ' ', t.hsal_tu)
                    AND c.estado_ci = 'ACTIVO'
                    AND t.estado_tu = 'ACTIVO'";

    $f_ciclo = mysqli_query($cn, $sql_ciclo);
    $r_ciclo = mysqli_fetch_assoc($f_ciclo);
    $numero_ciclo = $r_ciclo['total_ciclo'];

    if($numero_ciclo > 0){
        //VERIFICAR EL RANGO DE LOS TURNOS
        $horario = "SELECT COUNT(*) AS hora_total FROM turno 
        WHERE NOW() BETWEEN CONCAT(CURRENT_DATE, ' ', hent_tu) AND CONCAT(CURRENT_DATE, ' ', hsal_tu)";

        $f_horario = mysqli_query($cn, $horario);
        $r_horario = mysqli_fetch_assoc($f_horario);
        $numero_horario = $r_horario['hora_total'];

        if($numero_horario > 0){
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
                        c.nombre_ci,
                        t.nombre_tu,
                        t.hent_tu,
                        t.hsal_tu,
                        t.tolerancia_tu
                    FROM 
                        matricula m
                    INNER JOIN
                        ciclo c ON m.id_ci = c.id_ci 
                    INNER JOIN
                        detalle_ciclo_turno dt ON c.id_ci = dt.id_ci
                    INNER JOIN 
                        turno t ON dt.id_tu = t.id_tu
                    INNER JOIN 
                        alumno a ON a.id_al = m.id_al
                    WHERE 
                        a.dni_al = '$dniAlumno' AND
                        '$fechaHoraActual' BETWEEN CONCAT(CURRENT_DATE, ' ', t.hent_tu) AND CONCAT(CURRENT_DATE, ' ', t.hsal_tu)
                        AND m.estado_ma = 'ACTIVO'
                        AND c.estado_ci = 'ACTIVO'
                ";

                $resultado_c = mysqli_query($cn, $consulta);
                $temp = $resultado_c;

                $numero = mysqli_num_rows($temp);

                if ($numero > 0) {

                        $filama = mysqli_fetch_assoc($resultado_c); 
                        // Matrícula encontrada dentro del rango
                        $idMatricula = $filama['id_ma'];
                        $idTurno = $filama['id_tu'];
                        $hentTu = $filama['hent_tu'];
                        $hsalTu = $filama['hsal_tu'];
                        $tolerancia = $filama['tolerancia_tu'];
                        $turno = $filama['nombre_tu'];
                        $ciclo = $filama['nombre_ci'];

                        mysqli_free_result($resultado_c);

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
                                    $deuda = "S/. " . $fila['deuda_bo'];
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

                            if($estado_Asistencia != 'FALTA'){
                                    // Agregar resultado al arreglo
                            
                                    $sqlexistenci = "SELECT COUNT(*) as total FROM  matricula m INNER JOIN 
                                    detalle_ciclo_turno dt ON m.id_ci = dt.id_ci
                                    INNER JOIN turno t ON dt.id_tu = t.id_tu inner join asistencia asi on asi.id_ma = m.id_ma inner join alumno al on al.id_al = m.id_al
                                    where now() BETWEEN CONCAT(CURRENT_DATE, ' ', t.hent_tu) AND CONCAT(CURRENT_DATE, ' ', t.hsal_tu) and al.dni_al = '$dniAlumno'
                                    AND asi.fecha_as > CONCAT(CURRENT_DATE, ' ', t.hent_tu)";
    
                                    $fexistencia = mysqli_query($cn,$sqlexistenci);
                                    $rexistencia = mysqli_fetch_assoc($fexistencia);
                                    $cantidadexistencia = $rexistencia['total'];
                                    if($cantidadexistencia<1){
    
                                        $sql_al="SELECT * FROM alumno a
                                                INNER JOIN carrera c ON a.id_ca = c.id_ca
                                                INNER JOIN area ar ON c.id_ar = ar.id_ar
                                                WHERE a.dni_al = '$dniAlumno'";
                                        $f_al = mysqli_query($cn, $sql_al);
                                        $r_al = mysqli_fetch_assoc($f_al);
    
                                        //ALUMNO
                                        $nombre_al = ucwords(strtolower($r_al['apellido_al'].", ".$r_al['nombre_al']));
                                        $area_al =strtoupper( $r_al['nombre_ar'] );
    
                                        $fecha_nacimiento = new DateTime($r_al['fnac_al']);
                                        $hoy = new DateTime();
                                        $edad = $hoy->diff($fecha_nacimiento);
    
                                        //-------------
    
                                        $resultados[] = array(
                                            'escenario' => 4,
                                            'mensaje' => "La matrícula con ID $idMatricula está dentro del rango del turno. $hentTu - $hsalTu - Hora actual: $fechaHoraActual",
                                            'estadoa' => $estado_Asistencia,
                                            'idma' => $idMatricula,
                                            'deuda' => $deuda,
                                            'TARD' => $hentTuHoraFormatoConTolerancia,
                                            'TARDF' => $hsalTuTardanzaHoraFormato,
                                            'INI' => $hentTuHoraFormato,
                                            'FIN' => $hsalTuHoraFormato,
                                            'info' => "<div class='card-principal-info'>
                                                        <div class='card-asistencia-info'>
                                                            <h1>".$nombre_al."</h1>
                                                            <span>".$area_al."</span>
                                                        </div>
                                                        <div class='card-asistencia-info-image'>
                                                            <img src='src/assets/images/alumno/".$dniAlumno.".jpg' onerror='this.src=". "'src/assets/images/forma_pago/desconocido.jpg'".">
                                                        </div>
                                                    </div>
                                                    <div class='card-second-info'>
                                                        <span>".$edad->y." AÑOS</span>
                                                    </div>
                                                    <div class='card-asistencia-footer'>
                                                        <div class='asis-footer-info'>
                                                            <span>CICLO: </span>".$ciclo."
                                                        </div>
                                                        <div class='asis-footer-info'>
                                                            <span>DEUDA: </span> ".$deuda."
                                                        </div>
                                                        <div class='asis-footer-info'>
                                                            <span>TURNO: </span> ".$turno."
                                                        </div>
                                                    </div>",
    
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
                                                    'escenario' => 5,
                                                    'mensaje' => "Este alumno ya registro asistencia" 
                                                );
                                            
                                    }
    
                            }else{

                                $resultados[] = array(
                                    'escenario' => 7,
                                    'mensaje' => "Culmino horario de asistencia" 
                                );
                            }


                            

                        }else{
                            $resultados[] = array(
                                'escenario' => 3,
                                'mensaje' => "El alumno no tiene ninguna boleta actualmente activa" 
                            );
                        }
                } else {
                    // Manejar el error en la consulta si es necesario
                    $resultados[] = array(
                        'escenario' => 2,
                        'mensaje' => "El alumno esta fuera de Horario , Revise su matricula" 
                    );
                }
            } else {
            // El DNI del alumno no existe en la base de datos
            $resultados[] = array(
                'escenario' => 1,
                'mensaje' => "No existe un alumno con el DNI proporcionado."
            );
            }     
        }else{
            $resultados[] = array(
            'escenario' => 6,
            'mensaje' => "No es horario de clases"
            );
        }
    }else{
        $resultados[] = array(
            'escenario' => 6,
            'mensaje' => "No hay ciclos activos"
            );
    }

    

    // Liberar memoria después de la consulta de existencia
    mysqli_free_result($resultadoExistencia);
}

// Convertir el arreglo a formato JSON y enviarlo como respuesta
echo json_encode($resultados);
?>
