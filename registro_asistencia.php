<?php
include_once('auth.php');
include('config/conexion.php');

include_once('src/components/parte_superior.php');
include_once('modal_card_alumno.php');


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
                var rutaImagen = "./src/assets/images/alumno/" + data.dni + ".jpeg";

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

                $('#card-logo-img').attr('src', 'src/assets/images/alumno/' + data.dni + '.jpeg');
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        })
    }
</script>
<div class="container-page">
    <div>
        <p>Zeus<span> / Registro Asistencia</span></p>
        <h3>Asistencia</h3>
    </div>

    <div class="container-table col-md-12" style="background-color: #fff; overflow:hidden">
        <div class="row">
            <div class="col-md-3">
                <input type="date" class="form-control" name="fechaasis" id="fechaAsistencia">
            </div>
            <div class="col-md-3">
                <select name="lstciclo" class="form-control" id="cicloA">
                    <option value="" disabled selected>Selecciona un ciclo</option>
                    <?php
                    $sqlCICLO = "SELECT id_ci,nombre_ci from ciclo where estado_ci='ACTIVO'";
                    $fsqlc = mysqli_query($cn, $sqlCICLO);
                    while ($rsqlc = mysqli_fetch_assoc($fsqlc)) {
                    ?>
                        <option value=<?php echo $rsqlc['id_ci']; ?>><?php echo $rsqlc['nombre_ci']; ?></option>
                    <?php
                    } ?>
                </select>
            </div>

            <div class="col-md-3">

                <select name="lstturno" class="form-control" id="turnoA">
                    <option value="" disabled selected>Selecciona un turno</option>
                    <?php
                    $sqlTURNO = "SELECT * from turno where estado_tu = 'ACTIVO'";
                    $fturno = mysqli_query($cn, $sqlTURNO);
                    while ($rturno = mysqli_fetch_assoc($fturno)) {


                    ?>
                        <option value="<?php echo $rturno['id_tu'] ?>"> <?php echo $rturno['nombre_tu'] ?> </option>

                    <?php

                    }
                    ?>

                </select>
            </div>
            <div class="col-md-3">

                <select name="lstestado" class="form-control" id="estadoA">
                    <option value="" disabled selected>Selecciona un estado</option>
                    <option value="ASISTIO">ASISTIO</option>
                    <option value="TARDANZA">TARDANZA</option>
                    <option value="JUSTIFICADO">JUSTIFICADO</option>
                    <option value="FALTO">FALTO</option>

                </select>

            </div>
        </div>
    </div>


    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-striped table_id" id="table_registro_asistencia" style="width:100%; box-sizing: border-box; overflow:hidden">
                <thead align="center" style="color: #fff; background-color:#010133;">
                    <tr>
                        <th class="text-center">Fecha Asistencia</th>
                        <th class="text-center">Hora de Entrada</th>
                        <th class="text-center">Apellidos y Nombres</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Ciclo</th>
                        <th class="text-center">Turno</th>
                        <th class="text-center">Detalle</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <?php
                $sqlasistencia = "SELECT  m.* , a.*,dct.*  ,c.*,pe.*, t.*,asi.* FROM matricula m                  
                                    INNER JOIN alumno a on a.id_al = m.id_al
                                    INNER JOIN asistencia asi on m.id_ma = asi.id_ma
                                    INNER JOIN ciclo c on c.id_ci = m.id_ci
                                    INNER JOIN periodo pe on pe.id_pe = c.id_pe
                                    INNER JOIN detalle_ciclo_turno dct on dct.id_ci= c.id_ci
                                    INNER JOIN turno t on t.id_tu = dct.id_tu

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
                                                                    case 'FALTO':
                                                                        echo 'btnfalto';
                                                                        break;
                                                                    default:
                                                                        break;
                                                                }
                                                                ?>">
                                <p><?php echo $rsqlasis['estado_as']; ?></p>
                            </td>

                            <td align="center"><?php echo $rsqlasis['nombre_pe'] . $rsqlasis['nombre_ci']; ?></td>
                            <td align="center"><?php echo $rsqlasis['nombre_tu']; ?></td>
                            <td align="center">
                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalCardInfo" data-bs-whatever="@mdo" onclick="infoI(
                                                        '<?php echo $r['id_al'] ?? ''; ?>'
                                                    )">
                                    Más Info
                                </a>
                            </td>
                            <td align="center">
                                <center>

                                    <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent">
                                        <i class="fas fa-edit"></i></a>


                                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="">
                                        <i class="fas fa-trash"></i></a>
                                </center>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>
        </div>
    </div>
</div>






<?php

include_once('src/components/parte_inferior.php');
?>
<script src="src/assets/js/datatableIntegration.js"></script>

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
    document.getElementById("fechaAsistencia").value = returndatenow();
    $(document).ready(function() {
        var table = $('#table_registro_asistencia').DataTable({
            responsive: true,
            language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": " _TOTAL_ registros",
                "infoEmpty": "No hay registros para mostrar",
                "infoFiltered": "(filtrado de _MAX_  registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "sProcessing": "Cargando...",
            },
            dom: 'Bfrtilp',
            buttons: [{
                    extend: 'excelHtml5',
                    autofilter: true,
                    text: '<i class="fa-regular fa-file-excel"></i>',
                    titleAttr: 'Exportar a Excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }

                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa-regular fa-file-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    },
                    customize: function(doc) {

                        doc.content[1].table.body[0].forEach(function(h) {
                            h.fillColor = 'rgb(1, 1, 51)';
                        });
                    },
                },
                {
                    extend: 'print',
                    text: '<i class="fa-solid fa-print"></i>',
                    titleAttr: 'Imprimir',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    },

                },
            ]
        });

        new $.fn.dataTable.FixedHeader(table);
    });
</script>

<style>
    .btasistio .bttardanza .btnjustificacion .btnfalto {
        display: grid;
        place-items: center;
    }

    .btasistio p {
        background: #4FFB0F;
        border-radius: 15px;
        font-weight: 600;
        color: white;
        padding: 7px;

    }

    .bttardanza p {
        background: #FCB932;
        border-radius: 15px;
        font-weight: 600;
        color: white;
        padding: 7px;
    }

    .btnjustificacion p {
        background: #13F9C2;
        border-radius: 15px;
        font-weight: 600;
        color: white;
        padding: 7px;
    }

    .btnfalto p {
        background: #F31253;
        border-radius: 15px;
        font-weight: 600;
        color: white;
        padding: 7px;
    }
</style>