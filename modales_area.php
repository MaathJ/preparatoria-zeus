<!-- MODAL PARA EDITAR Usuario  -->
<div class="modal fade " id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR AREA:</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/area/U_area.php" method="post">
                    <div class="col-12">
                        <label for="area" class="form-label" style="color: black;">Area:</label>
                        <input type="text" name="txtarea" placeholder="Ingresar el Area" class="form-control" id="U_area" required>
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
                <input type="hidden" name="id_ar" id="id_ar" value="">

            </div>
            </form>
        </div>
    </div>
</div>





<!-- MODAL PARA REGISTRO Usuario  -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRAR AREA:</h4>
            </div>
            <div class="modal-body">
                <form action="area.php" method="post">
                    <div class="col-12">
                        <label for="area" class="form-label" style="color: black;">Area:</label>
                        <input type="text" name="txtarea" placeholder="Ingrese el area" class="form-control" id="area" required>
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


<?php
function deleteModalArea($id)
{
    echo <<<HTML
    <div class="modal fade" id="deleteModalArea{$id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                </div>
                <div class="modal-body">
                    <form action="app/controllers/area/D_area.php?id={$id}" method="POST">
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