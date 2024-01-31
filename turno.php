<?php
include_once('auth.php');
include_once('src/components/parte_superior.php');
include('config/conexion.php');
include('modales_turno.php');
?>

<link rel="icon" href="src/assets/images/logo-zeus.png">

<div class="container-page">
    <div>
        <p>Zeus<span> / Turno</span></p>
        <h3>Turno</h3>
    </div>
    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>
    <br>
    <div class="container-table" style="background-color: #fff;">
        <div class="col-md-12">
            <table class="table table-striped" id="table_turno">
                <thead align="center" style="color: #fff; background-color:#010133;">
                    <tr>
                        <th>Turno</th>
                        <th>Hora de Entrada</th>
                        <th>Hora de Salida</th>
                        <th>Tolerancia</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlTurno = "SELECT * FROM turno ";
                    $resultadoTurno = mysqli_query($cn, $sqlTurno);

                    while ($filaTurno = mysqli_fetch_assoc($resultadoTurno)) {
                    ?>
                        <?php
                        deleteModalTurno($filaTurno['id_tu']);
                        ?>
                        <tr>

                            <td align="center"><?php echo $filaTurno['nombre_tu']; ?></td>
                            <td align="center"><?php echo $filaTurno['hent_tu']; ?></td>
                            <td align="center"><?php echo $filaTurno['hsal_tu']; ?></td>
                            <td align="center"><?php echo $filaTurno['tolerancia_tu']; ?></td>
                            <td align="center"><?php
                                                $estado = $filaTurno['estado_tu'];
                                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                                echo $button;
                                                ?></td>
                            <td>
                                <center>
                                    <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                            'id': '<?php echo $filaTurno['id_tu'] ?? ''; ?>',
                                            'turno': '<?php echo $filaTurno['nombre_tu'] ?? ''; ?>',
                                            'horaentrada': '<?php echo $filaTurno['hent_tu'] ?? ''; ?>',
                                            'horasalida': '<?php echo $filaTurno['hsal_tu'] ?? ''; ?>',
                                            'tolerancia': '<?php echo $filaTurno['tolerancia_tu'] ?? ''; ?>',
                                            'estado': '<?php echo $filaTurno['estado_tu'] ?? ''; ?>'
                                                });">
                                        <i class="fas fa-edit"> </i></a>
                                    <a class="btn btn-danger btn-circle " target="_parent" data-bs-toggle="modal" data-bs-target="#DeleteModalTurno<?php echo $filaTurno['id_tu'] ?? ''; ?>" data-bs-whatever="@mdo">
                                        <i class="fas fa-trash"> </i>
                                    </a>
                                </center>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php
include_once('src/components/parte_inferior.php');
?>
<script>
    function cargar_info(dato) {
        document.getElementById('id_tu').value = dato.id;
        document.getElementById('U_turno').value = dato.turno;
        document.getElementById('U_hent').value = dato.horaentrada;
        document.getElementById('U_hsal').value = dato.horasalida;
        document.getElementById('U_tolerancia').value = dato.tolerancia;
        document.getElementById('U_estado').value = dato.estado;


    }

    function actualizarHoraSalida() {
        // Obtén el valor de la hora de entrada
        var horaEntrada = document.getElementById('hent').value;

        // Actualiza el campo de hora de salida para que no permita horas anteriores
        document.getElementById('hsal').min = horaEntrada;
    }

    function actualizarHoraSalidaEditar() {
        // Obtén el valor de la hora de entrada en el modal editar
        var horaEntradaEditar = document.getElementById('U_hent').value;

        // Actualiza el campo de hora de salida en el modal editar para que no permita horas anteriores
        document.getElementById('U_hsal').min = horaEntradaEditar;
    }
</script>

<script src="src/assets/js/datatableIntegration.js"></script>
<script>
    $(document).ready(function() {
            var table = $('#table_turno').DataTable({
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