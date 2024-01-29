<!-- Modal REGISTRAR -->
<div class="modal fade" id="Registrar_pago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #F39C12; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">
                    REGISTRAR PAGOS
                </h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/pago/R_pago.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="txt_volver" id="R-volver-pago" hidden>
                    <input type="text" name="txt_id" id="R-id-pago" hidden>
                    <input type="text" id="R-deuda-total" hidden>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="R-pago" class="col-form-label" style="color: black;">
                                    Cantidad:
                                    <input type="checkbox" id="R-check-pago"> Completo
                                </label>
                                <input type="number" name="txt_monto" class="form-control" id="R-pago-pago" required step="0.01" min="0.00" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="R-deuda-pago" class="col-form-label" style="color: black;">Deuda:</label>
                                <input type="text" name="txt_deuda" class="form-control" id="R-deuda-pago" required readonly>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <div class="form-inputs-pagos">
                                <?php
                                $sqlP = "SELECT * FROM forma_pago WHERE estado_fp = 'ACTIVO'";
                                $fP = mysqli_query($cn, $sqlP);
                                while ($rP = mysqli_fetch_assoc($fP)) {
                                ?>

                                    <div class="container-for">
                                        <div class="input-forma-pago">
                                            <input class="form-check-input" type="radio" name="opc_fp" value="<?php echo $rP['id_fp']; ?>">
                                            <img src="src/assets/images/forma_pago/<?php echo $rP['id_fp']; ?>.jpg" onerror="this.src='src/assets/images/forma_pago/desconocido.jpg'">
                                        </div>

                                        <label class="form-check-label" for="inlineCheckbox1">
                                            <?php echo $rP['nombre_fp']; ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">PAGAR</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal LISTA -->
<div class="modal fade" id="ModalPago" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F39C12; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel3">TODOS LOS PAGOS</h4>
            </div>
            <div class="modal-body" id="modal-content">
                <div class="row" id="cuerpo_pago">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <button type="submit" class="btn btn-primary">REGISTRAR</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="Eliminar_pago" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="color: #fff; background-color:#0A1048;">
                <h4 class="modal-title" id="exampleModalLabel2">CONFIRMACION DE ELIMINACION:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close" onclick="reopenFirstModal()"></button>
            </div>
            <div class="modal-body">
                <form action="app/controllers/pago/D_pago.php" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <h5>¿Está seguro que desea eliminar el pago?</h5>
                                <input type="text" name="cod_pa" id="cod_pa" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="reopenFirstModal()">CERRAR</button>
                        <button type="submit" class="btn btn-primary">ELIMINAR</button>
                        <input type="hidden" name="id_us" id="id_us">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT MODALES -->
<script type="text/javascript">
    function cargar_registro_pago(dato){
        document.getElementById('R-id-pago').value = dato.id_bo;
        document.getElementById('R-deuda-pago').value = dato.deuda_bo;
        document.getElementById('R-deuda-total').value = dato.deuda_bo;
        document.getElementById('R-pago-pago').max = dato.deuda_bo;
        document.getElementById('R-volver-pago').value = dato.volver_bo;
    }

    function cargar_eliminar_pago(dato){
        document.getElementById('D-id-pago').value = dato.id_pa;
    }

    function restar_deuda() {
        let precio = parseFloat(document.getElementById('R-deuda-total').value);
        let pago = parseFloat(document.getElementById('R-pago-pago').value);

        let total = precio - pago;

        document.getElementById('R-deuda-pago').value = total.toFixed(2) || 'Ingrese números válidos';
    }

    document.getElementById('R-pago-pago').addEventListener('change', restar_deuda);

    document.getElementById('R-check-pago').addEventListener('click', completo_deuda);
    
    function completo_deuda(estado) {
        let checkbox = document.getElementById('R-check-pago');
        let pago = document.getElementById('R-pago-pago');
        let precio = document.getElementById('R-deuda-total').value;

        // Verificar si el checkbox está marcado
        if (checkbox.checked) {
            pago.value = precio;
            pago.readOnly = true;
        } else {
            pago.value = "0";
            pago.readOnly = false;
        }

        restar_deuda();
    };
</script>




<!-- CSS y JS para FOTO-->
<style type="text/css">
    #foto,
    #U-foto {
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