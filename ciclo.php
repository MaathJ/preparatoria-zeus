<?php
include_once('auth.php');
include('config/conexion.php');
include_once('src/components/parte_superior.php');
include('modales_ciclo.php');
?>

<link rel="icon" href="src/assets/images/logo-zeus.png">

<div class="container-page">
    <div>
        <p>Zeus<span> / Ciclo</span></p>
        <h3>Ciclo</h3>
    </div>
    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalcicloRegistro" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>
    <br>
    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-striped table_id" id="table_ciclo" style="width:100%; box-sizing: border-box; overflow:hidden">
                <thead align="center" class="" style="color: #fff; background-color:#010133;">
                    <tr>
                        <th class="text-center">Ciclo</th>
                        <th class="text-center">Turnos</th>
                        <th class="text-center">Inicio</th>
                        <th class="text-center">Finalización</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Periodo</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlc = "SELECT ci.*, pe.* 
                                        FROM ciclo ci 
                                        INNER JOIN periodo pe ON ci.id_pe = pe.id_pe 
                                        GROUP BY ci.id_ci";
                    $fc = mysqli_query($cn, $sqlc);
                    while ($r = mysqli_fetch_assoc($fc)) {
                    ?>
                        <?php
                        $turnos = obtenerTurnosCiclo($r['id_ci'], $cn);
                        deleteModalCiclo($r['id_ci']);
                        ?>
                        <tr>
                            
                            <td align="center"><?php echo $r['nombre_pe'] . ' ' . $r['nombre_ci'] ?></td>
                            <td align="center">
                                <?php
                                $turnos_nombre_array = explode(', ', $turnos['turnos_nombre']);
                                $turnos_horario_array = explode(', ', $turnos['turnos_horario']);

                                for ($i = 0; $i < count($turnos_nombre_array); $i++) {
                                    echo $turnos_nombre_array[$i] . ' ' . $turnos_horario_array[$i] . '<br>';
                                }
                                ?>
                            </td>
                            <td align="center"><?php echo  date('d-m-Y ', strtotime($r['fini_ci'])) ?></td>
                            <td align="center"><?php echo  date('d-m-Y ', strtotime($r['ffin_ci']))  ?></td>
                            <td align="center"><?php echo 'S/ ' . $r['precio_ci'] ?></td>
                            <td align="center"><?php echo $r['nombre_pe'] ?></td>
                            <td align="center"><?php $estado = $r['estado_ci'];
                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                echo $button; ?></td>
                            <td align="center">
                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalcicloEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                        'id':'<?php echo $r['id_ci']; ?>',
                                        'nombre':'<?php echo $r['nombre_ci']; ?>',
                                        'fechainicio':'<?php echo date('Y-m-d', strtotime($r['fini_ci'])); ?>',
                                        'fechaculminacion':'<?php echo date('Y-m-d', strtotime($r['ffin_ci'])) ?? ''; ?>',
                                        'precio':'<?php echo $r['precio_ci'] ?>', 
                                        'periodo':'<?php echo $r['id_pe'] ?? ''; ?>', 
                                        'turno':'<?php echo $turnos['turnos_id'] ?? ''; ?>',
                                        'estado':'<?php echo $r['estado_ci'] ?? ''; ?>'
                                        });">
                                    <i class="fas fa-edit"> </i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar<?php echo $r['id_ci']; ?>">
                                    <i class="fas fa-trash"></i>
                                </a>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<?php

if (isset($_SESSION['deleted_ciclo'])) {
        echo
        '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Éxito!",
                text: "' . $_SESSION['deleted_ciclo'] . '",
                icon: "success"
            });
        }, 500);
    </script>';
        unset($_SESSION['deleted_ciclo']);
    }


    if (isset($_SESSION['error_ciclo'])) {
        echo
        '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Error!",
                text: "' . $_SESSION['error_ciclo'] . '",
                icon: "error"
            });
        }, 500);
        </script>';
        unset($_SESSION['error_ciclo']);
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
function obtenerTurnosCiclo($idx, $conexion)
{
    $sql = "SELECT GROUP_CONCAT(tu.nombre_tu SEPARATOR ', ') as turnos_nombre,
                    GROUP_CONCAT(tu.id_tu SEPARATOR ', ') as turnos_id,
                    GROUP_CONCAT(CONCAT_WS(' - ', DATE_FORMAT(tu.hent_tu, '%h:%i %p'), 
                    DATE_FORMAT(tu.hsal_tu, '%h:%i %p')) SEPARATOR ', ') as turnos_horario
            FROM detalle_ciclo_turno ct 
            INNER JOIN turno tu ON ct.id_tu = tu.id_tu
            WHERE ct.id_ci = $idx";

    $result = $conexion->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return [
            'turnos_nombre' => $row['turnos_nombre'] ?? '',
            'turnos_id' => $row['turnos_id'] ?? '',
            'turnos_horario' => $row['turnos_horario'] ?? ''
        ];
    }

    return [];
}


?>

<script src="src/assets/js/ciclo/Cargar_info.js"></script>
<?php
include_once('src/components/parte_inferior.php');
?>
<script src="src/assets/js/datatableIntegration.js"></script>

<script>
    $(document).ready(function() {
            var table = $('#table_ciclo').DataTable({
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