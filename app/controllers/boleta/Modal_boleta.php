


<link rel="stylesheet" href="../../../src/assets/css/boleta/forma_pago.css">


<!-- Modal REGISTRAR -->

<style>

.form-inputs-pagos .container-for .input-forma-pago {
    display: flex;
    align-items: center;
  }
  .form-inputs-pagos .container-for .input-forma-pago img {
    -o-object-fit: cover;
       object-fit: cover;
    height: 40px;
    width: 40px;
    border-radius: 50%;
  }

  .form-inputs-pagos {
    display: flex;
    flex-direction: row;
    gap: 2rem;
    padding: 0 0.5rem;
  }
  .form-inputs-pagos .container-for {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 6px;
  }
    
</style>


<div class="modal fade" id="Registrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">
                    REGISTRAR BOLETA
                </h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/boleta/R_boleta.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="txt_volver" id="R-volver" hidden>
                    <h4>NUEVA BOLETA</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="R-nro" class="col-form-label" style="color: black;">N° Boleta:</label>
                                <input type="text" name="txt_nboleta" class="form-control" id="R-nro" required>
                            </div>
                            <div class="mb-3">
                                <label for="R-fini" class="col-form-label" style="color: black;">Fecha inicio:</label>
                                <input type="date" name="txt_fini" class="form-control" id="R-fini" required oninput="agregar()" min="">
                            </div>
                           
                            <div class="mb-3">
                                <label for="R-mes" class="col-form-label" style="color: black;">Meses:</label>
                                <input type="number" name="txt_mes" class="form-control" id="R-mes" required value="1" min="1" max="12" oninput="agregar()" oninput="multiplicar()">
                            </div>
                        </div>
                        <div class="col-md-6">
                         
                            <div class="mb-3">
                                <label for="R-mensualidad" class="col-form-label" style="color: black;">Mensualidad:</label>
                                <input type="text" name="txt_mensual" class="form-control" id="R-mensualidad" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="R-ffin" class="col-form-label" style="color: black;">Fecha culminación:</label>
                                <input type="date" name="txt_ffin" class="form-control" id="R-ffin" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="R-precio" class="col-form-label" style="color: black;">Precio fijo:</label>
                                <input type="text" name="txt_precio" class="form-control" id="R-precio" required readonly>
                            </div>
                        </div>
                    </div>
                    <h4>REGISTRAR PAGO</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="R-pago" class="col-form-label" style="color: black;">
                                    Cantidad:
                                    <input type="checkbox" id="R-check"> Completo
                                </label>
                                <input type="number" name="txt_monto" class="form-control" id="R-pago" required step="0.01" min="0.00" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="R-deuda" class="col-form-label" style="color: black;">Deuda:</label>
                                <input type="text" name="txt_deuda" class="form-control" id="R-deuda" required readonly>
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
                                            <input class="form-check-input" required  type="radio" name="opc_fp" value="<?php echo $rP['id_fp']; ?>">
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
                        <button type="submit" class="btn btn-primary">REGISTRAR</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!--EDITAR BOLETA-->
<div class="modal fade  " id="Editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR BOLETA</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/boleta/U_boleta.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-6">
                                <label for="U-nro" class="col-form-label" style="color: black;">N° Boleta:</label>
                                <input type="text" name="txt_nboleta" class="form-control" id="U-nro" required>
                                <input type="text" name="txt_id" class="form-control" id="U-id" hidden>
                                <input type="text" name="txt_volver" class="form-control" id="U-volver" hidden>
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

<!--ELIMINAR BOLETA-->
<div class="modal fade" id="ModalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="color: #fff; background-color:#0A1048;">
                <h4 class="modal-title" id="exampleModalLabel">CONFIRMAR ELIMINACION DE LA BOLETA:</h4>
                <button type="button" class="btn-close" style="background-color: #ffffff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="app/controllers/boleta/D_boleta.php" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <h5>¿Está seguro que desea eliminar la boleta?</h5>
                                <input type="text" name="txt_id" id="D-id" class="form-control" hidden>
                                <input type="text" name="txt_volver" id="D-volver" class="form-control" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="">ELIMINAR</button>
                        <input type="hidden" name="id_us" id="id_us" value="">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- SCRIPT MODALES -->
<script type="text/javascript">
    function cargar_registro(dato){
        document.getElementById('R-mensualidad').value = dato.mensualidad;
        document.getElementById('R-precio').value = dato.mensualidad;
        document.getElementById('R-deuda').value = dato.mensualidad;
        document.getElementById('R-pago').max = dato.mensualidad;
        document.getElementById('R-volver').value = dato.volver;
        document.getElementById('R-fini').min = dato.fini;
        document.getElementById('R-fini').max = dato.ffin;
    }

    function cargar_editar(dato) {
        document.getElementById('U-volver').value = dato.volver;
        document.getElementById('U-id').value = dato.id;
        document.getElementById('U-nro').value = dato.bol;
    }

    function cargar_eliminar(dato) {
        document.getElementById('D-volver').value = dato.volver;
        document.getElementById('D-id').value = dato.id;
    }

    function agregar() {
        // Obtener el valor del input de fecha y membresia
        var fechaInput = document.getElementById('R-fini').value;
        var tiempo = parseFloat(document.getElementById('R-mes').value);

        // Crear un objeto de fecha con la fecha ingresada
        var fecha = new Date(fechaInput);

        // Agregar el tiempo a la fecha
        fecha.setMonth(fecha.getMonth() + tiempo);

        
        fecha.setDate(fecha.getDate());

        // Formatear la fecha resultante (opcional)
        var resultado = fecha.toLocaleDateString();

        // Formatear la fecha resultante para el input de tipo date
        var resultado = fecha.toISOString().split('T')[0];

        // Mostrar la fecha resultante en algún lugar de la página
        document.getElementById('R-ffin').value = resultado;
        tiempo = 0;
    }

    function multiplicar() {
        let mes = parseFloat(document.getElementById('R-mes').value);
        let mensualidad = parseFloat(document.getElementById('R-mensualidad').value);
        let pago = document.getElementById('R-pago')

        let numero = parseFloat(pago.value);

        let total = mes * mensualidad;

        document.getElementById('R-precio').value = total.toFixed(2) || 'Ingrese números válidos';
        pago.max = total;

        if(total < numero){
            pago.value = total;
        }

        completo("NO");
    }

    document.getElementById('R-mes').addEventListener('change', ()=>{
        multiplicar();
        restar();
    });

    function restar() {
        let precio = parseFloat(document.getElementById('R-precio').value);
        let pago = parseFloat(document.getElementById('R-pago').value);

        let total = precio - pago;

        document.getElementById('R-deuda').value = total.toFixed(2) || 'Ingrese números válidos';
    }

    document.getElementById('R-pago').addEventListener('change', restar);

    document.getElementById('R-check').addEventListener('click', ()=>{completo("SI");});
    
    function completo(estado) {
        let checkbox = document.getElementById('R-check');
        let pago = document.getElementById('R-pago');
        let precio = document.getElementById('R-precio').value;

        // Verificar si el checkbox está marcado
        if (checkbox.checked) {
            pago.value = precio;
            pago.readOnly = true;
        } else {
            if(estado == "SI"){
                pago.value = "0";
            }
            pago.readOnly = false;
        }

        restar();
    };
</script>


<!-- CSS y JS para FOTO-->
<!-- <style type="text/css">
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
</style> -->

<!-- <script src="src/assets/js/img.js"></script> -->