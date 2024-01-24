<!-- Modal REGISTRAR -->
<div class="modal fade" id="Registrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">
                    REGISTRAR FORMA DE PAGO
                </h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="app/controllers/forma_pago/R_formapago.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="C-nombre" class="col-form-label" style="color: black;">Nombre:</label>
                                <input type="text" name="txt_nomb" class="form-control" id="C-nombre" required maxlength="30">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3" style="margin-left: 15px;">
                                <img src="src/assets/images/img_fond.jpg" alt="avatar" id="img" width="200" height="200">
                                <input type="file" name="img_foto" id="foto" accept="image/*">
                                <label class="btn_img btn-primary" for="foto">AGREGAR FOTO</label>
                            </div>
                        </div>
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
<div class="modal fade" id="Editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">
                    EDITAR FORMA DE PAGO
                </h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="app/controllers/forma_pago/U_formapago.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- ID oculto -->
                        <input type="text" name="txt_id" id="U-id" required hidden>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="U-nombre" class="col-form-label" style="color: black;">Nombre:</label>
                                <input type="text" name="txt_nomb" class="form-control" id="U-nombre" required maxlength="100">
                            </div>
                            <div class="mb-3">
                                <label for="U-estado" class="col-form-label" style="color: black;">Estado:</label>
                                <select name="lst_estado" class="form-control" id="U-estado" required>
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3" style="margin-left: 15px;">
                                <img alt="avatar" id="U-img" onerror="this.src='src/assets/images/img_fond.jpg'" width="200" height="200">
                                <input type="file" name="img_foto" id="U-foto" accept="image/*">
                                <label class="btn_img btn-primary" for="U-foto">AGREGAR FOTO</label>
                            </div>
                        </div>
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
<div class="modal fade" id="Eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: red; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">
                ¡¡ ADVERTENCIA !! SE ELIMINARÁ UNA FORMA DE PAGO
                </h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="app/controllers/forma_pago/D_formapago.php" method="post">
                    <div class="row">
                        <!-- ID oculto -->
                        <input type="text" name="txt_id" id="D-id" required hidden>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label" style="color: black;">Nombre:</label>
                                <label class="col-form-label" style="color: black;" id="D-nombre"></label>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" style="color: black;">Estado:</label>
                                <label class="col-form-label" style="color: black;" id="D-estado"></label>
                            </div>
                        </div>
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
        document.getElementById('U-id').value = dato.id_fp;
        document.getElementById('U-nombre').value = dato.nombre_fp;
        document.getElementById('U-estado').value = dato.estado_fp;
        document.getElementById('U-img').src = "src/assets/images/forma_pago/" + dato.id_fp + ".jpg";
    }

    function cargar_eliminar(dato) {
        document.getElementById('D-id').value = dato.id_fp;
        document.getElementById('D-nombre').innerHTML = dato.nombre_fp;
        document.getElementById('D-estado').innerHTML = dato.estado_fp;
    }
</script>

<!-- CSS y JS para FOTO-->
<style type="text/css">
    #foto, #U-foto{
        display: none;
    }

    .btn_img {
        width: 200px;
        text-align: center;
        border-radius: 10px;
        margin-top: 5px;
        padding-top: 5px;
        height: 35px;
    }
</style>

<script src="src/assets/js/img.js"></script>