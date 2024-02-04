<?php
include_once('auth.php');
include('config/conexion.php');
include_once('src/components/parte_superior.php');
include_once('modal_card_alumno.php');

?>

<div class="container-page">
    <div>
        <p>Zeus<span> / Registro Asistencia</span></p>
        <h3>Asistencia</h3>
    </div>


    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
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
                (SELECT nombre_tu FROM turno WHERE id_tu = (SELECT id_tu FROM detalle_ciclo_turno WHERE id_ci = c.id_ci LIMIT 1)) AS nombre_tu
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
</div>


<!-- MODAL PARA REGISTRO Usuario  -->
<div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR ESTADO:</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/asistencia/U_asistencia.php" method="post" class="row g-3">
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






<?php

include_once('src/components/parte_inferior.php');
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

    $(document).ready(function() {
        var table = $('#table_registro_asistencia').DataTable({
            dom: 'PBlfrtip',
            stateSave: true,
            searchPanes: {
                initCollapsed: true,
                order: ['Fecha', 'Ciclo', 'Area', 'Turno', 'Estado'],
                threshold: 0.4,
                layout: 'columns-5',
                cascadePanes: true,
                viewTotal: true,
                dtOpts: {

                    dom: 'tp',
                    paging: 'true',
                    pagingType: "simple",
                    searching: true
                },

            },
            columnDefs: [{
                    searchPanes: {
                        name: 'Ciclo',
                        show: true
                    },
                    targets: [3]
                },
                {
                    searchPanes: {
                        name: 'Fecha',
                        show: true
                    },
                    targets: [0]
                },
                {
                    searchPanes: {
                        name: 'Area',
                        show: true
                    },
                    targets: [4]
                },
                {
                    searchPanes: {
                        name: 'Turno',
                        show: true
                    },
                    targets: [5]
                },
                {
                    searchPanes: {
                        name: 'Estado',
                        show: true
                    },
                    targets: [6]
                }
            ],
            responsive: true,
            language: {

                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                searchPanes: {
                    title: '',
                    countFiltered: '{shown}/{total}',
                },
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