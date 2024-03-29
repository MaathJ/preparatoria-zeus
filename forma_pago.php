<?php
include_once('auth.php');
include_once('config/conexion.php');
include_once('src/components/parte_superior.php');
include_once('app/controllers/forma_pago/Modal_formapago.php');
?>
<div class="container-page">
    <div>
        <p>Zeus<span> / Forma de pago</span></p>
        <h3>Forma de pago</h3>
    </div>
    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#Registrar" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>
    <br>
    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-striped table_id" id="table_formapago" style="width:100%; box-sizing: border-box; overflow:hidden">
                <thead align="center" class="" style="color: #fff; background-color:#010133;">
                    <tr>
                        <th class="text-center">Imagen</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Opciones</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM forma_pago
                        ORDER BY estado_fp";
                    $f = mysqli_query($cn, $sql);
                    while ($r = mysqli_fetch_assoc($f)) {
                    ?>
                        <tr align="center">
                            <td data-imagen="<?php echo $r['estado_fp']; ?>">
                                <img src="src/assets/images/forma_pago/<?php echo $r['id_fp']; ?>.jpg" onerror="this.src='src/assets/images/forma_pago/desconocido.jpg'" alt="Imagen" width="30" height="30">
                            </td>
                            <td data-estado="<?php echo $r['estado_fp']; ?>">
                                <?php echo $r['nombre_fp']; ?>
                            </td>
                            <td>
                                <?php
                                $estado = $r['estado_fp'];
                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                echo $button;
                                ?>
                            </td>
                            <td>
                                <!-- BOTON EDITAR -->
                                <button type="button" class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#Editar" onclick="cargar_editar({ 
                                    'id_fp': '<?php echo $r['id_fp']; ?>',
                                    'nombre_fp': '<?php echo $r['nombre_fp']; ?>',
                                    'estado_fp': '<?php echo $r['estado_fp']; ?>',
                                });"><i class="fas fa-edit"></i> </button>

                                <!-- BOTON ELIMINAR -->
                                <button type="button" class="btn btn-sm btn-danger btn-circle" data-bs-toggle="modal" data-bs-target="#Eliminar" onclick="cargar_eliminar({ 
                                    'id_fp': '<?php echo $r['id_fp']; ?>',
                                    'nombre_fp': '<?php echo $r['nombre_fp']; ?>',
                                    'estado_fp': '<?php echo $r['estado_fp']; ?>',
                                });"> <i class="fas fa-trash"></i> </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="styleSelector"> </div>
</div>

<?php
if (isset($_SESSION['success_message'])) {
    echo
    '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Éxito!",
            text: "' . $_SESSION['success_message'] . '",
            icon: "success"
        });
    }, 200);
</script>';
    unset($_SESSION['success_message']);
}

    if (isset($_SESSION['deleted_fpago'])) {
        echo
        '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Éxito!",
                text: "' . $_SESSION['deleted_fpago'] . '",
                icon: "success"
            });
        }, 500);
    </script>';
        unset($_SESSION['deleted_fpago']);
    }


    if (isset($_SESSION['error_fpago'])) {
        echo
        '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Error!",
                text: "' . $_SESSION['error_fpago'] . '",
                icon: "error"
            });
        }, 500);
        </script>';
        unset($_SESSION['error_fpago']);
    }

    if (isset($_SESSION['alert_message'])) {
        $alertMessage = $_SESSION['alert_message'];
        echo '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Cuidado!",
                text: "' . $alertMessage . '",
                icon: "warning"
            });
        }, 500);
        </script>';
        unset($_SESSION['alert_message']);
    }

    ?>

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
        var table = $('#table_formapago').DataTable({
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