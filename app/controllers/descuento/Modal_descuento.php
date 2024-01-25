<!-- Modal REGISTRAR -->
<div class="modal fade" id="Registrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">
                    REGISTRAR DESCUENTO
                </h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/descuento/R_descuento.php" method="post">
                            <div class="col-12">
                                <label for="C-nombre" class="col-form-label" style="color: black;">Nombre:</label>
                                <input type="text" name="txt_nomb" class="form-control" id="C-nombre" required maxlength="30">
                            </div>
                            <div class="col-12">
                                <label for="C-monto" class="col-form-label" style="color: black;">Monto descontado: (S/.)</label>
                                <input type="number" name="txt_monto" class="form-control" id="C-monto" step="0.01" required>
                            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">REGISTRAR</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal EDITAR -->
<div class="modal fade" id="Editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">
                    EDITAR DESCUENTO
                </h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/descuento/U_descuento.php" method="post">
                        <!-- ID oculto -->
                        <input type="text" name="txt_id" id="U-id" required hidden>
                            <div class="col-12">
                                <label for="U-nombre" class="col-form-label" style="color: black;">Nombre:</label>
                                <input type="text" name="txt_nomb" class="form-control" id="U-nombre" required maxlength="100">
                            </div>
                            <div class="col-12">
                                <label for="U-monto" class="col-form-label" style="color: black;">Monto descontado: (S/.)</label>
                                <input type="number" name="txt_monto" class="form-control" id="U-monto" step="0.01" required>
                            </div>
                            <div class="col-12">
                                <label for="U-estado" class="col-form-label" style="color: black;">Estado:</label>
                                <select name="lst_estado" class="form-control" id="U-estado" required>
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                </select>
                            </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal ELIMINAR -->
<div class="modal fade" id="Eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: red; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">
                    ¡¡ ADVERTENCIA !! SE ELIMINARÁ UN DESCUENTO
                </h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/descuento/D_descuento.php" method="post">
                        <!-- ID oculto -->
                        <input type="text" name="txt_id" id="D-id" required hidden>
                            <div class="col-12">
                                <label class="col-form-label" style="color: black;">Nombre:</label>
                                <label class="col-form-label" style="color: black;" id="D-nombre"></label>
                            </div>
                            <div class="col-12">
                                <label class="col-form-label" style="color: black;">Monto descontado: S/.</label>
                                <label class="col-form-label" style="color: black;" id="D-monto"></label>
                            </div>
                            <div class="col-12">
                                <label class="col-form-label" style="color: black;">Estado:</label>
                                <label class="col-form-label" style="color: black;" id="D-estado"></label>
                            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-danger">ELIMINAR</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- SCRIPT MODALES -->
<script type="text/javascript">
    function cargar_editar(dato) {
        document.getElementById('U-id').value = dato.id_de;
        document.getElementById('U-nombre').value = dato.nombre_de;
        document.getElementById('U-monto').value = dato.monto_de;
        document.getElementById('U-estado').value = dato.estado_de;
    }

    function cargar_eliminar(dato) {
        document.getElementById('D-id').value = dato.id_de;
        document.getElementById('D-nombre').innerHTML = dato.nombre_de;
        document.getElementById('D-monto').innerHTML = dato.monto_de;
        document.getElementById('D-estado').innerHTML = dato.estado_de;
    }
</script>