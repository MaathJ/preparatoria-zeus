<?php 
include_once('auth.php');

include_once('src/components/parte_superior.php');
?>

<?php
include('config/conexion.php');
?>
<link rel="icon" href="src/assets/images/logo-zeus.png">
<div class="container-page">
    <div>
        <p>Zeus<span> / Registro Asistencia</span></p>
        <h3>Asistencia</h3>
    </div>
<br>
<div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-striped table_id" id="table_registro_asistencia" style="width:100%; box-sizing: border-box; overflow:hidden">
                    <thead  align="center" style="color: #fff; background-color:#010133;">
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
                    <tbody>
                        <td align="center">29-01-24</td>
                        <td align="center">08:12</td>
                        <td>Cerna Atoche Walter</td>
                        <td align="center" class="button active-button">ASISTIÓ</td>
                        <td align="center">VERANO 2024-1</td>
                        <td align="center" >MAÑANA</td>
                        <td align="center"><b>VER INFO</b></td>
                        <td align="center">
                            <center>
                            
                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent"> 
                            <i class="fas fa-edit"></i></a>


                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="">
                            <i class="fas fa-trash"></i></a>
                            </center>
                        </td>
                    </tbody>

                    <tbody>
                        <td align="center">29-01-24</td>
                        <td align="center">08:37</td>
                        <td>Arévalo Nazario Diego Matias</td>
                        <td align="center" class="button inactive-button">TARDANZA</td>
                        <td align="center">VERANO 2024-1</td>
                        <td align="center">MAÑANA</td>
                        <td align="center"><b>VER INFO</b></td>
                        <td align="center">
                            <center>
                            
                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent"> 
                            <i class="fas fa-edit"></i></a>


                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="">
                            <i class="fas fa-trash"></i></a>
                            </center>
                        </td>
                    </tbody>

                    <tbody>
                        <td align="center">29-01-24</td>
                        <td align="center">--:--</td>
                        <td>Oblitas Jhon</td>
                        <td align="center" class="button inactive-button">FALTÓ</td>
                        <td align="center">VERANO 2024-1</td>
                        <td align="center">TARDE</td>
                        <td align="center"><b>VER INFO</b></td>
                        <td align="center">
                            <center>
                            
                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent"> 
                            <i class="fas fa-edit"></i></a>


                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="">
                            <i class="fas fa-trash"></i></a>
                            </center>
                        </td>
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