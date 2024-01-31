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
                        <th class="text-center">ID</th>
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
                            <td align="center"><?php echo $r['id_ci'] ?></td>
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
    initializeDataTable('#table_ciclo');
</script>