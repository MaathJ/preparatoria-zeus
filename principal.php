<?php
include_once("auth.php");
include('./config/conexion.php');
include_once("src/components/parte_superior.php");
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
<script>
    function infoCard(dato) {
        asisIdAlumno = dato;
        console.log(asisIdAlumno)
        $.ajax({
            url: './Alumno/actions/cardinfo.php',
            type: 'POST',
            data: {
                id_alI: asisIdAlumno
            },
            dataType: 'json',
            success: function(data) {
                // Actualizar elementos dentro del modal usando los IDs

                $('#card-user').text(data.nombre);
                $('#card-edad').text(data.edad);
                $('#card-estado').text(data.estado);
                let estadoTexto = $('#card-estado').text().trim();
                if (estadoTexto === 'ACTIVO') {
                    $('#card-estado').css({
                        'color': 'green',
                        'font-weight': 'bold'
                    })
                } else {
                    $('#card-estado').css({
                        'color': 'red',
                        'font-weight': 'bold'
                    })
                }
                // Actualizar elementos dentro del modal usando los IDs
                var rutaImagen = "./src/assets/images/alumno/" + data.dni + ".jpg";

                // Establecer la fuente de la imagen
                $('#card-imgA').attr('src', rutaImagen);
                $('#card-dni').text(data.dni);
                $('#card-fnac').text(data.fechaNacimiento);
                $('#card-cel').text(data.telefono);
                $('#card-dir').text(data.direccion);
                $('#card-col').text(data.colegio);
                $('#card-uni').text(data.universidad);
                $('#card-napo').text(data.apoderado);
                $('#card-ntel').text(data.telefonoApoderado);
                $('#card-carrera').text(data.nombre_carrera);
                $('#card-area').text(data.nombre_area);
                let telApoderado = $('#card-ntel').text().trim();
                let dataApoderado = $('#card-napo').text().trim();
                console.log({
                    telApoderado,
                    dataApoderado
                })
                if (telApoderado === "" && dataApoderado === "") {
                    $('#apo-icon-1').css({
                        'display': 'none'
                    })
                    $('#apo-icon-2').css({
                        'display': 'none'
                    })

                } else {
                    $('#apo-icon-1').css({
                        'display': 'block'
                    })
                    $('#apo-icon-2').css({
                        'display': 'block'
                    })
                }

                $('#card-logo-img').attr('src', 'src/assets/images/alumno/' + data.dni + '.jpg');
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        })
    }
</script>
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
        <div class="table_principal">
            <center>
                <h3>Matrículas del día</h3>
            </center>
            <?php
            $sql = "SELECT 
                alumno.nombre_al AS nombre_alumno,
                alumno.apellido_al AS apellido_alumno,
                alumno.dni_al AS dni_alumno,
                usuario.usuario_us AS nombre_usuario,
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
                                <?php echo $fila['nombre_usuario'] ?>
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


        <div class="table_principal">
            <center>
                <h3>Matrículas del día Por Ciclo </h3>
            </center>
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
                                    <?php echo "<b>PER-CICLO:</b> " . $row["periodo"] . " " . $row["ciclo"] . " - <b>CANT</b>: " . $row["cantidad_matriculas"] . "<br>"; ?>
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






        <div class="table_principal">
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
                                <?php echo 'S/. ' . $fila_deuda['monto_deuda']; ?>
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
<div class="container-table" style="background-color: #fff; overflow:hidden">
    <div class="col-md-12" style="box-sizing: border-box; ">
        <table class="table table-striped table_id" id="table_registro_asistencia" style="width:100%; box-sizing: border-box; overflow:hidden">
            <thead align="center" style="color: #fff; background-color:#010133;">
                <tr>
                    <th class="text-center">Fecha Asistencia</th>
                    <th class="text-center">Hora de Entrada</th>
                    <th class="text-center">Apellidos y Nombres</th>
                    <th class="text-center">Ciclo</th>
                    <th class="text-center">Area</th>
                    <th class="text-center">Turno</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Detalle</th>
                    <th class="text-center">Opciones</th>
                </tr>
            </thead>
            <?php
            date_default_timezone_set('America/Lima');
            $fechaHoraActual = date('Y-m-d H:i:s');
            $sqlasistencia = "SELECT 
                ar.*,
                car.*,
                m.*,
                a.*,
                c.*,
                pe.*,
                asi.*,
                t.nombre_tu AS nombre_tu
            FROM 
                asistencia asi
            INNER JOIN  
                matricula m ON m.id_ma = asi.id_ma
            INNER JOIN 
                alumno a ON a.id_al = m.id_al
            INNER JOIN 
                carrera car ON a.id_ca = car.id_ca
            INNER JOIN 
                area ar ON ar.id_ar = car.id_ar
            INNER JOIN 
                ciclo c ON c.id_ci = m.id_ci
            INNER JOIN 
                periodo pe ON pe.id_pe = c.id_pe
            INNER JOIN 
                detalle_ciclo_turno dt ON c.id_ci = dt.id_ci
            INNER JOIN 
                turno t ON dt.id_tu = t.id_tu
            WHERE 
                asi.fecha_as BETWEEN CONCAT(CURRENT_DATE, ' ', t.hent_tu) AND CONCAT(CURRENT_DATE, ' ', t.hsal_tu)
            ";
            $fsqlasis = mysqli_query($cn, $sqlasistencia);

            ?>
            <tbody>
                <?php
                while ($rsqlasis = mysqli_fetch_assoc($fsqlasis)) {
                ?>
                    <tr>

                        <td align="center"><?php echo date('d-m-Y', strtotime($rsqlasis['fecha_as'])); ?></td>
                        <td align="center"><?php echo date('H:i:s', strtotime($rsqlasis['fecha_as'])); ?></td>
                        <td> <?php echo $rsqlasis['apellido_al'] . ' ' . $rsqlasis['nombre_al'];  ?></td>
                        <td align="center"><?php echo $rsqlasis['nombre_pe'] . $rsqlasis['nombre_ci']; ?></td>
                        <td align="center"><?php echo $rsqlasis['nombre_ar']; ?></td>
                        <td align="center"><?php echo $rsqlasis['nombre_tu']; ?></td>
                        <td align="center" class="button <?php
                                                            switch ($rsqlasis['estado_as']) {
                                                                case 'ASISTIO':
                                                                    echo 'btasistio';
                                                                    break;
                                                                case 'TARDANZA':
                                                                    echo 'bttardanza';
                                                                    break;
                                                                case 'JUSTIFICADO':
                                                                    echo 'btnjustificacion';
                                                                    break;
                                                                case 'FALTA':
                                                                    echo 'btnfalto';
                                                                    break;
                                                            }
                                                            ?>">

                            <p><?php echo $rsqlasis['estado_as']; ?></p>
                        </td>

                        <td align="center">
                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalCardInfo" data-bs-whatever="@mdo" onclick="infoCard(
                                                        '<?php echo $rsqlasis['id_al'] ?? ''; ?>'
                                                    )">
                                Más Info <i class="fa-solid fa-phone-volume"></i>
                            </a>
                        </td>
                        <td align="center">
                            <center>

                                <a class="btn btn-sm btn-success btn-circle" data-bs-toggle="modal" data-bs-target="#ModalEditar" data-bs-whatever="@mdo" onclick="cargar_info({
                                        'id':'<?php echo $rsqlasis['id_as']; ?>',
                                        'estado':'<?php echo $rsqlasis['estado_as'] ?? ''; ?>'
                                        });">
                                    <i class="fa-solid fa-clock"></i></a>



                            </center>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
</div>

<div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR ESTADO:</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/asistencia/U_asistencia_principal.php" method="post" class="row g-3">
                    <div class="col-12 mb-3">
                        <label for="turno" class="form-label">Estados:</label>


                        <select name="u_lstestado" class="form-control" id="u_estado">

                            <option value="ASISTIO">ASISTIO</option>
                            <option value="TARDANZA">TARDANZA</option>
                            <option value="FALTA">FALTA</option>
                            <option value="JUSTIFICADO">JUSTIFICADO</option>


                        </select>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="u_cod" id="u_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">EDITAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</style>


<script>
    function cargar_info(dato) {

        document.getElementById('u_estado').value = dato.estado;
        document.getElementById('u_id').value = dato.id;

        console.log(dato.estado);


    }
</script>

<script>
    function returndatenow() {
        // Obtiene la fecha actual en UTC
        const fechaActualUTC = new Date();

        // Ajusta la fecha para la zona horaria de Perú (Lima) (UTC-5)
        const fechaActualLima = new Date(fechaActualUTC.getTime() - 5 * 60 * 60 * 1000);

        // Obtiene las partes de la fecha
        const year = fechaActualLima.getUTCFullYear();
        const month = fechaActualLima.getUTCMonth() + 1; // Meses en JavaScript se cuentan desde 0
        const day = fechaActualLima.getUTCDate();

        // Formatea la fecha en el formato yyyy-MM-dd
        const fechaHoyPeru = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
        return fechaHoyPeru;
    }
</script>


<script>
    $(document).ready(function() {
        var table = $('#table_registro_asistencia').DataTable({
            scrollY: '300px',
            "bPaginate": false,
            responsive: true,
            dom: 'PBlfrtip',
            stateSave: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
                "decimal": "",
                "emptyTable": "No hay asistencias encontradas",
                "info": "Mostrando de _START_ a _END_ de _TOTAL_ Asistencias",
                "infoEmpty": "Mostrando  0 Asistencias",
                "infoFiltered": "(Filtrado de _MAX_ Asistencias)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Asistencias",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },

            buttons: [{
                    extend: "excel",
                    className: "buttonsToHide"
                },
                {
                    extend: "pdf",
                    className: "buttonsToHide"
                },
                {
                    extend: "print",
                    className: "buttonsToHide"
                }
            ],
        });
        new $.fn.dataTable.FixedHeader(table);
    });
    1
</script>

<style>
    .dt-buttons {
        display: none !important;
    }
    .btasistio p,
    .bttardanza p,
    .btnjustificacion p,
    .btnfalto p {
        width: auto;
        border: none;
        font-size: 12px;
        border-radius: 12px;
        padding: 0.3rem 1.7rem;
        color: white;
        font-weight: bold;
        display: flex;
        place-content: center;
    }

    .btasistio p {
        background: #4FFB0F;

    }

    .bttardanza p {
        background: #FCB932;
    }

    .btnjustificacion p {
        background: #13F9C2;
    }

    .btnfalto p {
        background: red;
    }

</style>

<?php
include_once("src/components/parte_inferior.php")
?>