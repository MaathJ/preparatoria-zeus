<?php
include_once("auth.php");
include_once("src/components/parte_superior.php");
include('./config/conexion.php');
include_once('limpiezaciclo.php');

include_once('./app/controllers/boleta/U_estadoboleta.php');

// Verificar si es un nuevo día
if ($_SESSION["usuario"] && !isset($_SESSION["last_access_date"]) || $_SESSION["last_access_date"] != date('Y-m-d')) {
    // Si es un nuevo día, realiza las acciones necesarias
    $_SESSION["last_access_date"] = date('Y-m-d');
    
    echo '
    <script>
        setTimeout(() => {
            Swal.fire({
                height: 300,
                width: 300,
                text: "Bienvenido! ' . $_SESSION['n_usuario'] . '",
                imageUrl: "src/assets/images/logo-zeus.png",
                imageWidth: 150,
                imageHeight: 150,
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
            });
        }, 100);
    </script>';
}

?>

<link rel="stylesheet" href="src/assets/css/dashboard/dashboard.css">

<div class="container-page">
    <div>
        <p>Zeus<span> / Panel de Control</span></p>
        <h3>Panel de Control</h3>
    </div>
    <form action="backup.php" method="post">
        <button class="btn btn-primary" style="cursor: pointer; margin-bottom:10px;" name="backup_btn" value="Generar Backup">Generar BackUp</button>
    </form>

    <div class="card-earnings">
        <div class="card-earnings-title" align="center">
            <span><i class="fa-solid fa-door-open"></i></span>
            <p style="font-weight: 500; font-size: 30px;">Asistencia Total del día</p>
    </div>


        <?php
                        date_default_timezone_set('America/Lima');
                        $fechaActual = date("Y-m-d");

                
                $sql = "SELECT COUNT(*) AS cantidad_asistentes
                    FROM asistencia
                    WHERE fecha_as >= '$fechaActual' AND estado_as = 'ASISTIO'";

               
                $result = mysqli_query($cn, $sql);

               
                if ($result) {
                
                $row = $result->fetch_assoc();

               
                echo $row['cantidad_asistentes'];
                
                } else {
              
                echo "Error en la consulta: " . $conn->error;
                }

                ?>      

        
       
    </div>

    <div class="content-left-tables">
        <div class="table">
            <h3>Matrículas del día</h3>
            <?php
            $sql = "SELECT 
                alumno.nombre_al AS nombre_alumno,
                alumno.apellido_al AS apellido_alumno,
                alumno.dni_al AS dni_alumno,
                usuario.nombre_us AS nombre_usuario,
                usuario.apellido_us AS apellido_usuario,
                DATE_FORMAT(matricula.freg_ma, '%H:%i') AS hora
                FROM matricula
                INNER JOIN alumno ON matricula.id_al = alumno.id_al
                INNER JOIN usuario ON matricula.id_us = usuario.id_us
                WHERE DATE(matricula.freg_ma) = CURDATE()";

            $resultado = mysqli_query($cn, $sql);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                // Iterar sobre los resultados
                while ($fila = mysqli_fetch_assoc($resultado)) {
            ?>
                    <div class="content-table-one">
                        <div class="table-card">
                            <div class="table-card-info">
                                <div class="card-info">
                                    <img class="img-fluid" src="./src/assets/images/alumno/<?php echo $fila['dni_alumno'] ?>.jpg">
                                </div>
                                <div>
                                    <?php echo $fila['nombre_alumno'] . ' ' . $fila['apellido_alumno']; ?>
                                </div>
                            </div>
                            <div class="table-card-days">
                                <?php echo $fila['nombre_usuario'] . ' ' . $fila['apellido_usuario']; ?>
                            </div>
                            <div class="table-card-days">
                                <?php echo $fila['hora']; ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No hay matrículas diarias.</p>';
            }
            ?>
        </div>

        <div class="content-left-tables">
        <div class="table">
            <h3>Matrículas del día Por Ciclo </h3>
            <?php
           $sql = "
           SELECT
             p.nombre_pe AS periodo,
             c.nombre_ci AS ciclo,
             COUNT(m.id_ma) AS cantidad_matriculas
           FROM
             matricula m
           JOIN
             ciclo c ON m.id_ci = c.id_ci
           JOIN
             periodo p ON c.id_pe = p.id_pe
           WHERE
             m.estado_ma = 'ACTIVO' AND c.estado_ci = 'ACTIVO'  -- Agregar condición para matrículas y ciclos activos
           GROUP BY
             p.nombre_pe, c.nombre_ci
           ORDER BY
             p.nombre_pe, c.nombre_ci;
       ";
    
    $result = mysqli_query($cn, $sql);

    if ($result->num_rows > 0) {
        // Imprimir resultados
        while ($row = $result->fetch_assoc()) {

            ?>
            <div class="content-table-one">
                <div class="table-card">
                    <div class="table-card-info">
                        <div class="card-info">
                        <?php  echo "Periodo: " . $row["periodo"] . " - Ciclo: " . $row["ciclo"] . " - Cantidad de matrículas: " . $row["cantidad_matriculas"] . "<br>"; ?>
                        </div>
                       
                    </div>
                   
                </div>
            </div>
    <?php


  
        }
    } else {
        echo "No se encontraron resultados.";
    }
            ?>
        </div>






        <div class="table">
            <h3>Alumnos con deuda</h3>
            <?php
            $sql = "SELECT alumno.nombre_al AS nombre_alumno, 
                          alumno.apellido_al AS apellido_alumno,
                          alumno.dni_al AS dni_alumno, 
                          boleta.deuda_bo AS monto_deuda
                    FROM boleta
                    INNER JOIN matricula ON boleta.id_ma = matricula.id_ma
                    INNER JOIN alumno ON matricula.id_al = alumno.id_al
                    WHERE boleta.estadodeu_bo = 'DEUDA'";

            $resultado_deuda = mysqli_query($cn, $sql);

            if ($resultado_deuda && mysqli_num_rows($resultado_deuda) > 0) {
                while ($fila_deuda = mysqli_fetch_assoc($resultado_deuda)) {
            ?>
                    <div class="content-table-one">
                        <div class="table-card">
                            <div class="table-card-info">
                              <div class="card-info">
                                    <img class="img-fluid" src="./src/assets/images/alumno/<?php echo $fila_deuda['dni_alumno'] ?>.jpg">
                                </div>
                                <div><?php echo $fila_deuda['nombre_alumno'] . ' ' . $fila_deuda['apellido_alumno']; ?></div>
                            </div>
                            <div class="table-card-days">
                                <?php echo 'S/. '.$fila_deuda['monto_deuda']; ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No hay alumnos con deuda.</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php
include_once("src/components/parte_inferior.php")
?>
