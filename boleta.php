<?php
include_once('auth.php');
include_once('config/conexion.php');
include_once('src/components/parte_superior.php');
include_once('app/controllers/boleta/Modal_boleta.php');
include_once('app/controllers/pago/Modal_pago.php');
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
?>
<link rel="stylesheet" href="src/assets/css/boleta/forma_pago.css">

<div class="container-page">
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT ma.*, ci.*, al.*, ar.*,pe.*
            FROM matricula ma
            INNER JOIN ciclo ci ON ma.id_ci = ci.id_ci
            INNER JOIN alumno al ON al.id_al = ma.id_al
            INNER JOIN carrera ca ON al.id_ca = ca.id_ca
            INNER JOIN area ar ON ca.id_ar = ar.id_ar
            INNER JOIN periodo pe ON pe.id_pe= ci.id_pe
            WHERE ma.id_ma = $id";
        $f = mysqli_query($cn, $sql);
        if ($r = mysqli_fetch_assoc($f)) {
            $mensualidad = $r['mensualidad_ma'];
            $inicio = $r['fini_ci'];
            $final = $r['ffin_ci'];
            $texto = "";

            //DATOS ALUMNO
            $dni = $r['dni_al'];
            $nombre = $r['apellido_al'] . ", " . $r['nombre_al'];
            $area = $r['nombre_ar'];
            $periodo = $r['nombre_pe'];
            //------------
            //DATOS MATRICULA
            $ciclo = $r['nombre_ci'];
            $mat_ini = strtotime($r['fini_ci']);
            $mat_fin = strtotime($r['ffin_ci']);
            $fecha_ini = date('d', $mat_ini) . " de " . $meses[date('n', $mat_ini) - 1] . " de " . date('Y', $mat_ini);
            $fecha_fin = date('d', $mat_fin) . " de " . $meses[date('n', $mat_fin) - 1] . " de " . date('Y', $mat_fin);
            //---------------

            $sql_fecha = "SELECT estadodeu_bo, ffin_bo FROM boleta WHERE id_ma = $id ORDER BY ffin_bo DESC LIMIT 1";
            $f_fecha = mysqli_query($cn, $sql_fecha);
            if ($r_fecha = mysqli_fetch_assoc($f_fecha)) {
                $inicio = $r_fecha['ffin_bo'];
                $texto = $r_fecha['estadodeu_bo'];
            }
    ?>
            <input type="hidden" value="<?php echo $id; ?>" id="id_para_volver">
            <p>Zeus<span> / Boleta</span></p>
            <h3>Boleta</h3>
            <?php
            if ($texto != "DEUDA") {
            ?>
                <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#Registrar" data-bs-whatever="@mdo" style="cursor: pointer;" onclick="cargar_registro({
                    'mensualidad': '<?php echo $mensualidad; ?>',
                    'volver':'<?php echo $id; ?>',
                    'fini':'<?php echo $inicio; ?>',
                    'ffin':'<?php echo $final; ?>'
                })">
                    <i class="fa-solid fa-plus text-white"></i> Registrar
                </button>

                <a href="matricula.php" style="text-decoration: none; background-color: #FFC107;" class="turno btn " > <i class="fa-solid fa-rotate-left"></i> VOLVER </a>
            <?php } ?>
            <br>
            <div class="container-table" style="background-color: #fff; overflow:hidden">
                <div class="col-md-12" style="box-sizing: border-box;">
                    <table class="table table-striped table_id" id="table_boleta" style="width:100%; box-sizing: border-box; overflow:hidden">
                        <thead class="text-center" class="" style="color: #fff; background-color:#010133;">
                            <tr>
                                <th>N° Boleta</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha culminación</th>
                                <th>Meses pagados</th>
                                <th>Monto Total</th>
                                <th>Deuda</th>
                                <th>Estado de la deuda</th>
                                <th>Estado de la boleta</th>
                                <th>Pagos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlB = "SELECT * FROM boleta WHERE id_ma = $id ORDER BY ffin_bo DESC";
                            $fB = mysqli_query($cn, $sqlB);
                            while ($rB = mysqli_fetch_assoc($fB)) {
                            ?>
                                <tr>
                                    <td align="center">

                                        <?php echo $rB['nroboleta_bo']; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo date('d-m-Y ', strtotime($rB['fini_bo'])); ?>
                                    </td>
                                    <td align="center">
                                        <?php echo date('d-m-Y ', strtotime($rB['ffin_bo'])); ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $rB['mes_bo']; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $rB['preciofijo_bo']; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $rB['deuda_bo']; ?>
                                    </td>
                                    <td align="center">
                                        <?php $estado = $rB['estadodeu_bo'];
                                        $button = '<button class="' . ($estado === "PAGADO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                        echo $button;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $estado = $rB['estadodur_bo'];
                                        $class = '';

                                        switch ($estado) {
                                            case 'ACTIVO':
                                                $class = 'active-button';
                                                break;
                                            case 'EN ESPERA':
                                                $class = 'waiting-button';
                                                break;
                                            default:
                                                $class = 'inactive-button';
                                                break;
                                        }

                                        $button = '<button class="' . $class . '">' . $estado . '</button>';
                                        echo $button;
                                        ?>
                                    </td>

                                    <td align="center">
                                        <a class="btn btn-sm btn-primary btn-circle ver-pagos-btn" id="abrir_pago" data-bs-toggle="modal" data-bs-target="#ModalPago" data-bs-whatever="@mdo" data-id-bo="<?php echo $rB['id_bo']; ?>"><i class="fa-solid fa-money-bill"></i></a>
                                    </td>
                                    <td align="center">
                                        <!-- BOTON EDITAR -->
                                        <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#Editar" data-bs-whatever="@mdo" onclick=" cargar_editar({
                                                'bol':' <?php echo $rB['nroboleta_bo'] ?? ''; ?> ',
                                                'id':' <?php echo $rB['id_bo'] ?? ''; ?> ',
                                                'volver':'<?php echo $id; ?>',
                                            } )">
                                            <i class="fas fa-edit"> </i></a>

                                        <!-- BOTON ELIMINAR -->
                                        <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#ModalEliminar" data-bs-whatever="@mdo" onclick=" cargar_eliminar({
                                                'id':' <?php echo $rB['id_bo'] ?? ''; ?> ',
                                                'volver':'<?php echo $id; ?>',
                                            } )"><i class="fas fa-trash"> </i></a>

                                        <!-- BOTON AGREGAR PAGO -->
                                        <?php
                                        if ($rB['deuda_bo'] != 0) {
                                        ?>
                                            <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#Registrar_pago" onclick="cargar_registro_pago({
                                            'id_bo': '<?php echo $rB['id_bo']; ?>',
                                            'deuda_bo': '<?php echo $rB['deuda_bo']; ?>',
                                            'volver_bo':'<?php echo $id; ?>',
                                        });"> 
                                                <i class="fa-solid fa-sack-dollar"></i> </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    <?php
        } else {
            echo "<div class='container-table' style='background-color: #fff;'>
                        Esta página no existe
                        </div>";
        }
    } else {
        echo "<div class='container-table' style='background-color: #fff;'>
                Esta página no existe
            </div>";
    }
    ?>






</div>
<div class="boleta-user-card">
    <div class="boleta-user-img">
        <img src="src/assets/images/alumno/<?php echo $dni ?>.jpg">
    </div>
    <div class="boleta-user-info">
        <h2>ALUMNO</h2>
        <h3>NOMBRE:</h3><?php echo $nombre ?>
        <h3>DNI:</h3><?php echo $dni ?>
        <h3>ÁREA:</h3><?php echo $area ?>
    </div>
    <div class="boleta-user-matricula">
        <h2>MATRICULA</h2>
        <h3>CICLO: </h3><?php echo $periodo.$ciclo ?>
        <h3>INICIO: </h3><?php echo $fecha_ini ?>
        <h3>FINAL: </h3><?php echo $fecha_fin ?>
    </div>
</div>


<div class="modal fade" id="boletaExistenteModal" tabindex="-1" role="dialog" aria-labelledby="boletaExistenteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="boletaExistenteModalLabel">Número de Boleta Existente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta número de boleta ya existe.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var mensaje = urlParams.get('mensaje');

        if (mensaje === '1') {
            $('#boletaExistenteModal').modal('show');

            $('#boletaExistenteModal').on('hidden.bs.modal', function() {
                if (history.replaceState) {
                    var urlWithoutParams = window.location.protocol + "//" + window.location.host + window.location.pathname;
                    history.replaceState(null, null, urlWithoutParams);
                }
            });

            $('#boletaExistenteModal').on('click', '.close', function() {
                if (history.replaceState) {
                    var urlWithoutParams = window.location.protocol + "//" + window.location.host + window.location.pathname;
                    history.replaceState(null, null, urlWithoutParams);
                }
                $('#boletaExistenteModal').modal('hide');
            });
        }
    });
</script>



<!-- SCRIPT PARA LISTA PAGOS-->
<script>
    $(document).ready(function() {
        $('.ver-pagos-btn').click(function() {
            var idBo = $(this).data('id-bo');
            $.ajax({
                type: 'GET',
                url: 'app/controllers/pago/obtener_pagos.php',
                data: {
                    id_bo: idBo
                },
                success: function(response) {
                    $('#cuerpo_pago').html(response);
                },
                error: function() {
                    console.error('Error al cargar los pagos.');
                }
            });
        });
    });
</script>
<!-- SCRIPT ESTADO -->
<script src="src/assets/js/estado.js"></script>

<?php
include_once('src/components/parte_inferior.php');
?>

<script src="src/assets/js/datatableIntegration.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#table_boleta').DataTable({
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
                        columns: [0,1, 2, 3, 4, 5]
                    }

                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa-regular fa-file-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    exportOptions: {
                        columns: [0,1, 2, 3, 4, 5]
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
                        columns: [0,1, 2, 3, 4, 5]
                    },

                },
            ]
        });

        new $.fn.dataTable.FixedHeader(table);
    });
</script>