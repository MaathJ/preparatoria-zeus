<?php
include_once('auth.php');
include_once("src/components/parte_superior.php");
include('config/conexion.php');
$sql = "SELECT * FROM area";
$f = mysqli_query($cn, $sql);
include('modales_area.php');
?>


<div class="container-page">
    <div>
        <p>Zeus<span>/Área</span></p>
        <h3>Área</h3>
    </div>
    <button type="button" class="area btn btn-primary " style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
        Registrar
    </button>
    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-striped" id="table_area" style="width:100%; box-sizing: border-box; overflow:hidden">
                <thead align="center" class="" style="color: #fff; background-color:#010133;">
                    <tr>

                        <th class="text-center">Nombre</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($r = mysqli_fetch_assoc($f)) {
                    ?>
                        <?php
                        deleteModalArea($r['id_ar']);
                        ?>

                        <tr>
                            <td class="text-center"><?php echo $r['nombre_ar']; ?></td>
                            <td align="center">
                                <?php
                                $estado = $r['estado_ar'];
                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                echo $button;
                                ?>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                            
                              'area': '<?php echo isset($r['nombre_ar']) ? $r['nombre_ar'] : ''; ?>',
                                 
                                 'estado': '<?php echo isset($r['estado_ar']) ? $r['estado_ar'] : ''; ?>',
                                  'id': '<?php echo isset($r['id_ar']) ? $r['id_ar'] : ''; ?>',
                                    });">
                                    <i class="fas fa-edit"> </i></a>

                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalArea<?php echo $r['id_ar']; ?>">
                                    <i class="fas fa-trash"></i>
                                </a>


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

if (isset($_SESSION['deleted_area'])) {
    echo
    '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Éxito!",
            text: "' . $_SESSION['deleted_area'] . '",
            icon: "success"
        });
    }, 500);
    </script>';
    unset($_SESSION['deleted_area']);
}

if (isset($_SESSION['error_area'])) {
    echo
    '<script>
    setTimeout(() => {
        Swal.fire({
            title: "¡Ups!",
            text: "' . $_SESSION['error_area'] . '",
            icon: "error"
        });
     }, 500);
    </script>';
    unset($_SESSION['error_area']);
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

<?php
include_once("src/components/parte_inferior.php")
?>


<script>
    function cargar_info(dato) {

        document.getElementById('U_area').value = dato.area;
        document.getElementById('U_estado').value = dato.estado;
        document.getElementById('id_ar').value = dato.id;

    }
</script>

<script>
    $(document).ready(function() {
        var table = $('#table_area').DataTable({
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
                        columns: [0, 1]
                    }

                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa-regular fa-file-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    exportOptions: {
                        columns: [0, 1]
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
                        columns: [0, 1]
                    },

                },
            ]
        });

        new $.fn.dataTable.FixedHeader(table);
    });
</script>


<!-- Recibiendo por metodo post el formulario  -->

