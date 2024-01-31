<!-- MODAL PARA EDITAR Usuario  -->
<div class="modal fade " id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR CARRERA:</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/carrera/U_carrera.php" method="post">
                    <div class="col-12">
                        <label for="carrera" class="form-label" style="color: black;">Carrera:</label>
                        <input type="text" name="txtcarrera" placeholder="Ingresar la carrera" class="form-control" id="U_carrera" required>
                    </div>
                    <div class="col-12">
                        <label for="area" class="form-label" style="color: black;">Area:</label>
                        <select class="form-control" name="lstarea" id="U_area" required>
                            <option value="" disabled selected>Selecciona un area</option>
                            <?php
                            $sql = "SELECT *
                                    FROM area ";
                            $f = mysqli_query($cn, $sql);
                            while ($r = mysqli_fetch_assoc($f)) {
                            ?>
                                <option value="<?php echo $r['id_ar'] ?>"><?php echo $r['nombre_ar']  ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="estado" class="form-label" style="color: black;">Estado:</label>
                        <select class="form-control" name="lstestado" id="U_estado" required>
                            <option value="" disabled selected>Selecciona un Estado</option>
                            <option value="ACTIVO" require>ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="submit" class="btn btn-primary" id="">Editar</button>
                <input type="hidden" name="id_ca" id="id_ca" value="">
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Page-body end -->
</div>


<!-- MODAL PARA REGISTRO Usuario  -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRAR CARRERA:</h4>
            </div>
            <div class="modal-body">
                <form action="carrera.php" method="post">
                    <div class="col-12">
                        <label for="carrera" class="form-label" style="color: black;">Nombre:</label>
                        <input type="text" name="txtcarrera" placeholder="Ingrese el nombre" class="form-control" id="carrera" required>
                    </div>
                    <div class="col-12">
                        <label for="area" class="col-form-label" style="color: black;">Area:</label>
                        <select class="form-control" name="lstarea" id="area" required>
                            <option value="" disabled selected>Selecciona un area</option>
                            <?php
                            $sql = "SELECT *
                                    FROM area ";
                            $f = mysqli_query($cn, $sql);
                            while ($r = mysqli_fetch_assoc($f)) {
                            ?>
                                <option value="<?php echo $r['id_ar'] ?>"><?php echo $r['nombre_ar']  ?></option>

                            <?php
                            }
                            ?>
                        </select>

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
<!-- Page-body end -->
</div>


<!-- MODAL PARA CONFIRMAR ELIMINACIÓN -->
<?php
function deleteModalCarrera($id)
{
    echo <<<HTML
    <div class="modal fade" id="DeleteModalCarrera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                        <h4 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                    </div>
                    <div class="modal-body">
                    <form action="app/controllers/carrera/D_carrera.php?id={$id}" method="POST">
                        ¿Estas seguro de que quieres eliminar esta carrera?
                        <button class="btn btn-danger btn-circle">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    HTML;
}
?>