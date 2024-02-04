<!-- MODAL PARA REGISTRO Usuario  -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO TURNO:</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/turno/R_turno.php" method="post" class="row g-3">
                    <div class="col-12 mb-3">
                        <label for="turno" class="form-label">Turno:</label>
                        <input type="text" name="txtturno" placeholder="Ingrese el turno" class="form-control" id="turno" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="hent" class="form-label">H. Entrada:</label>
                        <input type="time" name="txthent" class="form-control" id="hent" onchange="actualizarHoraSalida()" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="hsal" class="form-label">H. Salida:</label>
                        <input type="time" name="txthsal" class="form-control" id="hsal" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="tolerancia" class="form-label">Tolerancia:</label>
                        <input type="number" name="txttolerancia" class="form-control" id="tolerancia" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- MODAL PARA EDITAR Usuario  -->
<div class="modal fade " id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR TURNO:</h4>
                <h1 id=""></h1>
            </div>
            <div class="modal-body">
                <form action="app/controllers/turno/U_turno.php" method="post" class="row g-3">
                    <div class="col-12">
                        <label for="turno" class="form-label">Turno:</label>
                        <input type="text" name="txtturno" placeholder="Ingrese el Turno" class="form-control" id="U_turno" required>
                    </div>
                    <div class="col-12">
                        <label for="hent" class="form-label">H. Entrada:</label>
                        <input type="time" name="txthent" class="form-control" id="U_hent" onchange="actualizarHoraSalidaEditar()" required>

                    </div>
                    <div class="col-12">
                        <label for="hsal" class="form-label">H. Salida:</label>
                        <input type="time" name="txthsal" class="form-control" id="U_hsal" required>
                    </div>

                    <div class="col-12">
                        <label for="tolerancia" class="form-label">Tolerancia:</label>
                        <input type="number" name="txttolerancia" class="form-control" id="U_tolerancia" required>
                    </div>

                    <div class="col-12">
                        <label for="estado" class="form-label">Estado:</label>
                        <select class="form-control" name="lstestado" id="U_estado" required>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="">Editar</button>
                        <input type="hidden" name="id_tu" id="id_tu" value="">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
function deleteModalTurno($id)
{
    echo <<<HTML
    <div class="modal fade" id="DeleteModalTurno{$id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                        <h4 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h4>
                    </div>
                    <div class="modal-body">
                    <form action="app/controllers/turno/D_Turno.php?id={$id}" method="POST">
                        ¿Estás seguro de que quieres eliminar este periodo?
                        <button class="btn btn-danger btn-circle">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    HTML;
}
?>
