
<?php 
include_once('auth.php');

include_once('src/components/parte_superior.php');
?>

<?php
include('config/conexion.php');
?>

<div class="container-page">
    <div>
        <p>Zeus<span> / Ciclo</span></p>
        <h3>Ciclo</h3>
    </div>

    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalcicloRegistro" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>

    <br>
    <div class="container-table" style="background-color: #fff;">
        <div class="col-md-12">
            <table class="table table-striped" id="table_ciclo">
            <thead align="center" class="" style="color: #fff; background-color:#010133;">
                                    <tr>
                                        <th>ID</th>
                                        <th>CICLO</th>
                                        <th>Turnos</th>
                                        <th>Fecha de Inicio</th>
                                        <th>Fecha de Finalización</th>
                                        <th>Precio</th>
                                        <th>Periodo</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
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
                                        $turnos = obtenerTurnosCiclo($r['id_ci'], $cn);

                                       
                                    ?>
                                        <tr>
                                            <td><?php echo $r['id_ci'] ?></td>
                                            <td><?php echo $r['nombre_pe'].' '.$r['nombre_ci'] ?></td>
                                            <td>
                                                <?php 
                                                    $turnos_nombre_array = explode(', ', $turnos['turnos_nombre']);
                                                    $turnos_horario_array = explode(', ', $turnos['turnos_horario']);
                                                    
                                                    for ($i = 0; $i < count($turnos_nombre_array); $i++) { 
                                                        echo $turnos_nombre_array[$i] . ' ' . $turnos_horario_array[$i] . '<br>';
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo  date('d-m-Y ', strtotime($r['fini_ci'])) ?></td>
                                            <td><?php echo  date('d-m-Y ', strtotime($r['ffin_ci']))  ?></td>
                                            <td><?php echo 'S/ '. $r['precio_ci'] ?></td>
                                            <td><?php echo $r['nombre_pe'] ?></td>
                                            <td><?php $estado = $r['estado_ci'];
                                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                                echo $button; ?></td>
                                            <td>
                                            <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalcicloEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                        'id':'<?php echo $r['id_ci']; ?>',
                                        'nombre':'<?php echo $r['nombre_ci']; ?>',
                                        'fechainicio':'<?php echo date('Y-m-d', strtotime($r['fini_ci'])); ?>',
                                        'fechaculminacion':'<?php echo date('Y-m-d', strtotime($r['ffin_ci']))?? ''; ?>',
                                        'precio':'<?php echo $r['precio_ci'] ?>', 
                                        'periodo':'<?php echo $r['id_pe']?? ''; ?>', 
                                        'turno':'<?php echo $turnos['turnos_id']?? ''; ?>',
                                        'estado':'<?php echo $r['estado_ci']?? ''; ?>'
                                        });">
                                        <i class="fas fa-edit"> </i>
                                    </a>

                                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="<?php echo $r['id_ci']; ?>">
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




<!-- MODAL PARA REGISTRAR REGISTRAR  -->
<div class="modal fade" id="ModalcicloRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <form action="app/controllers/ciclo/R_ciclo.php" method="post">

            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO CICLO:</h4>
            </div>
            <div class="modal-body row g-3">

                <!-- Columna izquierda -->
                <div class="col-md-6">
                    <div class="col-12 mb-3">
                        <label for="rol" class="col-form-label" style="color: black;">Nombre:</label>
                        <input type="text" name="r_nombre" placeholder="Ingrese el Nombre" class="form-control" id="turno" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="fechaInicio" class="col-form-label" style="color: black;">Fecha Inicio:</label>
                        <input type="date" name="r_fechainicio" placeholder="Ingrese el Nombre" class="form-control" id="fechaInicio" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="fechaCulminacion" class="col-form-label" style="color: black;">Fecha Culminacion:</label>
                        <input type="date" name="r_fechaculminacion" placeholder="Ingrese el Nombre" class="form-control" id="fechaCulminacion" required>
                    </div>
                </div>

                         <!-- Columna derecha -->
                <div class="col-md-6">
                    <div class="col-12 mb-3">
                        <label for="periodo" class="col-form-label" style="color: black;">Periodo:</label>
                        <select name="lstperiodo" class="form-select form-select-sm mb-3" id="periodo">
                            <?php
                            $sqlp = "SELECT * FROM  periodo WHERE estado_pe= 'ACTIVO' ";
                            $f = mysqli_query($cn, $sqlp);
                            while ($rp = mysqli_fetch_assoc($f)) {
                            ?>
                                <option value="<?php echo $rp['id_pe'] ?>"><?php echo $rp['nombre_pe'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="precio" class="col-form-label" style="color: black;">Precio:</label>
                        <input type="number" name="r_precio" placeholder="Ingrese el Monto" class="form-control" id="precio" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="turnos" class="col-form-label" style="color: black;">TURNOS:</label>

                                    <br>
                                    <?php
                                    $sqlt = "SELECT * FROM turno WHERE estado_tu 
                                    = 'ACTIVO'";

                                    $ft = mysqli_query($cn, $sqlt);

                                    while ($rt = mysqli_fetch_assoc($ft)) {


                                    ?>
                                        <input type="checkbox" name="checkturno[]" value="<?php echo $rt['id_tu'] ?>" id="">
                                        <?php echo $rt['nombre_tu'] . '/' . date('H:i A', strtotime($rt['hent_tu'])) . '-' . date('H:i A', strtotime($rt['hsal_tu'])) ?>
                                        <br>


                                    <?php
                                    }
                                    ?>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="submit" class="btn btn-primary" id="registrar">Registrar</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR EL CICLO  -->
<div class="modal fade" id="ModalcicloEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR CICLO:</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/ciclo/U_ciclo.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="rol" class="col-form-label" style="color: black;">Nombre:</label>
                                <input type="text" name="u_nombre" placeholder="Ingrese el Nombre" class="form-control" id="u_nombre" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="fechaInicio" class="col-form-label" style="color: black;">Fecha Inicio:</label>
                                <input type="date" name="u_fechainicio" class="form-control" id="u_fechainicio" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="fechaCulminacion" class="col-form-label" style="color: black;">Fecha Culminacion:</label>
                                <input type="date" name="u_fechaculminacion" class="form-control" id="u_fechaCulminacion" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="fechaCulminacion" class="col-form-label" style="color: black;">Estado :</label>
                                <select name="u_lstestado" class="form-select form-select-sm mb-3" id="u_estado">
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                    <option value="FINALIZADO">FINALIZADO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="periodo" class="col-form-label" style="color: black;">Periodo:</label>
                                <select name="u_lstperiodo" class="form-select form-select-sm mb-3" id="u_periodo" required>
                                    <option value="" disabled selected>Selecciona un periodo</option>
                                    <?php
                                    $sqlpe = "SELECT * FROM  periodo WHERE estado_pe= 'ACTIVO' ";
                                    $fpe = mysqli_query($cn, $sqlpe);
                                    while ($rpe = mysqli_fetch_assoc($fpe)) {
                                    ?>
                                        <option value="<?php echo $rpe['id_pe']; ?>"><?php echo $rpe['nombre_pe']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="precio" class="col-form-label" style="color: black;">Precio:</label>
                                <input type="number" name="u_precio" placeholder="Ingrese el Nombre" class="form-control" id="u_precio" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="turnos" class="col-form-label" style="color: black;">TURNOS:</label>

                                    <br>
                                    <?php
                                    $sqlt = "SELECT * FROM turno WHERE estado_tu 
                                    = 'ACTIVO'";

                                    $ft = mysqli_query($cn, $sqlt);

                                    while ($rt = mysqli_fetch_assoc($ft)) {


                                    ?>
                                        <input type="checkbox" name="checkturnoEditar[]" value="<?php echo $rt['id_tu'] ?>" id="u_turno">
                                        <?php echo $rt['nombre_tu'] . '/' . date('H:i A', strtotime($rt['hent_tu'])) . '-' . date('H:i A', strtotime($rt['hsal_tu'])) ?>
                                        <br>


                                    <?php
                                    }
                                    ?>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">EDITAR</button>
                        <input type="hidden" name="cod" id="u_id">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>


<!-- MODAL PARA CONFIRMAR ELIMINACIÓN -->
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este Ciclo?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Agregar el atributo data-id al botón para almacenar el ID del turno -->
                <a href="#" class="btn btn-danger" id="confirmarEliminar" data-id="" style="text-decoration:none;">
                    Confirmar
                </a>
            </div>
        </div>
    </div>
</div>


<script src="src/assets/js/ciclo/Cargar_info.js"></script>


<?php 

function obtenerTurnosCiclo($idCi, $conexion) {
    $sql = "SELECT GROUP_CONCAT(tu.nombre_tu SEPARATOR ', ') as turnos_nombre,
                    GROUP_CONCAT(tu.id_tu SEPARATOR ', ') as turnos_id,
                    GROUP_CONCAT(CONCAT_WS(' - ', DATE_FORMAT(tu.hent_tu, '%h:%i %p'), 
                    DATE_FORMAT(tu.hsal_tu, '%h:%i %p')) SEPARATOR ', ') as turnos_horario
            FROM detalle_ciclo_turno ct 
            INNER JOIN turno tu ON ct.id_tu = tu.id_tu
            WHERE ct.id_ci = $idCi";

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

<?php 

include_once('src/components/parte_inferior.php');
?>
<script src="src/assets/js/datatableIntegration.js"></script>

<script>initializeDataTable('#table_ciclo');</script>