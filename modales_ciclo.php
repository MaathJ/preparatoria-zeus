<!-- MODAL PARA REGISTRAR REGISTRAR  -->
<div class="modal fade" id="ModalcicloRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="app/controllers/ciclo/R_ciclo.php" method="post">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">REGISTRO CICLO:</h4>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <div class="col-12 mb-3">
                            <label for="rol" class="col-form-label" style="color: black;">Nombre:</label>
                            <input type="text" name="r_nombre" placeholder="Ingrese el Nombre" class="form-control" id="turno" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="fechaInicio" class="col-form-label" style="color: black;">Fecha de Inicio:</label>
                            <input type="date" name="r_fechainicio" placeholder="Ingrese el Nombre" class="form-control" id="fechaInicio" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="fechaCulminacion" class="col-form-label" style="color: black;">Fecha de Culminación:</label>
                            <input type="date" name="r_fechaculminacion" placeholder="Ingrese el Nombre" class="form-control" id="fechaCulminacion" required>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="col-12 mb-3">
                            <label for="periodo" class="col-form-label" style="color: black;">Periodo:</label>
                            <select name="lstperiodo" class="form-control form-select-sm mb-3" id="periodo">
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
                            <label for="turnos" class="col-form-label" style="color: black;">Turnos:</label>

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
                                <label for="fechaInicio" class="col-form-label" style="color: black;">Fecha de Inicio:</label>
                                <input type="date" name="u_fechainicio" class="form-control" id="u_fechainicio" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="fechaCulminacion" class="col-form-label" style="color: black;">Fecha de Culminación:</label>
                                <input type="date" name="u_fechaculminacion" class="form-control" id="u_fechaCulminacion" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="fechaCulminacion" class="col-form-label" style="color: black;">Estado :</label>
                                <select name="u_lstestado" class="form-control form-select-sm mb-3" id="u_estado">
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                    <option value="FINALIZADO">FINALIZADO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="periodo" class="col-form-label" style="color: black;">Periodo:</label>
                                <select name="u_lstperiodo" class="form-control form-select-sm mb-3" id="u_periodo" required>
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
                                <label for="turnos" class="col-form-label" style="color: black;">Turnos:</label>

                                <br>
                                <?php
                                $sqlt = "SELECT * FROM turno WHERE estado_tu 
                                    = 'ACTIVO'";

                                $ft = mysqli_query($cn, $sqlt);

                                while ($rt = mysqli_fetch_assoc($ft)) {


                                ?>
                                    <input type="checkbox" name="checkturnoEditar[]" value="<?php echo $rt['id_tu'] ?>"   id="u_turno" require >
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

<?php
function deleteModalCiclo($id)
{

    echo <<<HTML
    <div class="modal fade" id="modalConfirmarEliminar{$id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                </div>
                <div class="modal-body">

                    <form action="app/controllers/Ciclo/D_Ciclo.php?id={$id}" method="POST">
                        ¿Estas seguro de que quieres eliminar este ciclo?
                        <button class="btn btn-danger btn-circle">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    HTML;
}

?>

<?php
