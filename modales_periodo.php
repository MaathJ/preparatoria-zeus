<?php

function deleteModalPeriodo($id)
{
    echo <<<HTML
    <div class="modal fade" id="DeleteModalPeriodo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">Registro Periodo Academico</h4>
                </div>
                <div class="modal-body">
                    <form action="app/controllers/periodo/D_periodo.php?id={$id}" method="POST">
                        Estas seguro de que quieres eliminar este periodo?
                        <button class="btn btn-danger btn-circle">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
HTML;
}

?>
<div class="modal fade" id="editarModalPeriodo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR TIPO RUTINA</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/periodo/U_periodo.php" method="POST" class="row g-3">
                    <div class="col-12">
                        <!-- <label class="form-label" for="id_periodo">Id</label> -->
                        <input class="form-control" name="txt_id_periodo" type="text" id="id_periodo"  hidden>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="periodo">Nombre Periodo</label>
                        <input class="form-control" name="txt_periodo" type="text" id="edit_nombre_periodo">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="estado">Estado</label>
                        <select class="form-control" name="txt_estado_edit" id="estado" required>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModalPeriodo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">Registro Periodo Academico</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/periodo/R_periodo.php" method="POST">
                    <div class="col-12">
                        <label class="form-label" for="periodo">Nombre Periodo</label>
                        <input class="form-control" type="text" name="txt_periodo" placeholder="Ingresa el periodo" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>