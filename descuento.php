<?php 
include_once('auth.php');
include_once('config/conexion.php');
include_once('app/controllers/descuento/Modal_descuento.php');
include_once('src/components/parte_superior.php');
?>

<link rel="icon" href="src/assets/images/logo-zeus.png">

<div class="container-page">
    <div>
        <p>Zeus<span> / Descuento</span></p>
        <h3>Descuento</h3>
    </div>
    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#Registrar" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>
                        <br>
                        <!-- Tabla -->
                        <div class="container-table" style="background-color: #fff; overflow:hidden">
                            <div class="col-md-12" style="box-sizing: border-box;">
                                <table class="table table-striped table_id" id="table_descuento" style="width:100%; box-sizing: border-box; overflow:hidden">
                                <thead align="center" class=""  style="color: #fff; background-color:#010133;">
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql="SELECT * FROM descuento
                                        ORDER BY estado_de";
                                        $f=mysqli_query($cn, $sql);
                                        while($r=mysqli_fetch_assoc($f)){
                                    ?>
                                        <tr>
                                        <td align="center"><i class="fa-solid fa-eye"></i> <?php echo $r['nombre_de']; ?></td>
                                        <td align="center"><?php echo $r['monto_de']; ?></td>
                                        <td align="center"><?php
                                                $estado = $r['estado_de'];
                                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                                echo $button;
                                                ?></td>
                                
                                            <td align="center">
                                                <!-- BOTON EDITAR -->
                                                <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#Editar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_editar({ 
                                                    'id_de': '<?php echo $r['id_de']; ?>',
                                                    'nombre_de': '<?php echo $r['nombre_de']; ?>',
                                                    'monto_de': '<?php echo $r['monto_de']; ?>',
                                                    'estado_de': '<?php echo $r['estado_de']; ?>',
                                                });"><i class="fas fa-edit"> </i></a></a>

                                                <!-- BOTON ELIMINAR -->
                                                <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Eliminar" onclick="cargar_eliminar({ 
                                                    'id_de': '<?php echo $r['id_de']; ?>',
                                                    'nombre_de': '<?php echo $r['nombre_de']; ?>',
                                                    'monto_de': '<?php echo $r['monto_de']; ?>',
                                                    'estado_de': '<?php echo $r['estado_de']; ?>',
                                                });"> <i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>

<!-- SCRIPT ESTADO -->
<script src="src/assets/js/estado.js"></script>
<!-- STYLE ESTADO -->
<link rel="stylesheet" href="src/assets/css/estado.css">

<?php 

include_once('src/components/parte_inferior.php');
?>

<script src="src/assets/js/datatableIntegration.js"></script>

<script>
$(document).ready(function() {
            var table = $('#table_descuento').DataTable({
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