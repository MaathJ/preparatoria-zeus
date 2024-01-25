<?php
include_once('auth.php');
include_once('src/components/parte_superior.php');
include('config/conexion.php');
?>

 

<div class="container-page">
    <div>
        <p>Zeus<span> / Turno</span></p>
        <h3>Turno</h3>
    </div>

    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>

    <br>
    <div class="container-table" style="background-color: #fff;">
        <div class="col-md-12">
        <table class="table table-striped" id="table_turno">
                    <thead  align="center" style="color: #fff; background-color:#010133;">
                        <tr>
                            <th>Turno</th>
                            <th>Hora de Entrada</th>
                            <th>Hora de Salida</th>
                            <th>Tolerancia</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlTurno = "SELECT * FROM turno ORDER BY id_tu DESC";
                        $resultadoTurno = mysqli_query($cn, $sqlTurno);

                        while ($filaTurno = mysqli_fetch_assoc($resultadoTurno)) {
                        ?>
                            <tr>
                                <td align="center"><?php echo $filaTurno['nombre_tu']; ?></td>
                                <td align="center"><?php echo $filaTurno['hent_tu']; ?></td>
                                <td align="center"><?php echo $filaTurno['hsal_tu']; ?></td>
                                <td align="center"><?php echo $filaTurno['tolerancia_tu']; ?></td>
                                <td align="center"><?php
                                                $estado = $filaTurno['estado_tu'];
                                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                                echo $button;
                                                ?></td>
                                <td>
                                <center>
                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                            'turno': '<?php echo $filaTurno['nombre_tu'] ?? ''; ?>',
                                            'horaentrada': '<?php echo $filaTurno['hent_tu'] ?? ''; ?>',
                                            'horasalida': '<?php echo $filaTurno['hsal_tu'] ?? ''; ?>',
                                            'tolerancia': '<?php echo $filaTurno['tolerancia_tu'] ?? ''; ?>',
                                            'estado': '<?php echo $filaTurno['estado_tu'] ?? ''; ?>',
                                            'id': '<?php echo $filaTurno['id_tu'] ?? ''; ?>',
                                            
                                                });">
                                            <i class="fas fa-edit"> </i></a>


                                    <!-- Agregar el atributo data-bs-toggle y data-bs-target para abrir el modal -->
                                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="<?php echo $filaTurno['id_tu']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </center>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>

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
                        <label for="hsal" class="form-label">H. Salida:</label>
                        <input type="time" name="txthsal" class="form-control" id="hsal" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="hent" class="form-label">H. Entrada:</label>
                        <input type="time" name="txthent" class="form-control" id="hent" onchange="actualizarHoraSalida()" required>
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


<!-- MODAL PARA CONFIRMAR ELIMINACIÓN -->
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este turno?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" class="btn btn-danger" id="confirmarEliminar" data-id="" style="text-decoration:none;">
                        Confirmar
                    </a>
                </div>
        </div>
    </div>
</div>

<script>
    // Manejar el evento de clic en el botón de eliminar del modal
    $(document).on('click', '#confirmarEliminar', function () {
        // Obtener el ID del turno
        var idTurno = $(this).data('id');
        // Redirigir a la página de eliminación con el ID del turno
        window.location.href = 'app/controllers/turno/D_turno.php?cod=' + idTurno;
    });

    // Actualizar el ID del turno en el modal al abrirse
    $(document).on('show.bs.modal', '#modalConfirmarEliminar', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var idTurno = button.data('id'); // Extraer la información de los atributos data-*
        var modal = $(this);
        // Actualizar el atributo data-id del botón de confirmarEliminar con el ID del turno
        modal.find('#confirmarEliminar').data('id', idTurno);
    });
</script>


<script>
    function cargar_info(dato) {
        
        document.getElementById('U_turno').value = dato.turno;
        document.getElementById('U_hent').value = dato.horaentrada;
        document.getElementById('U_hsal').value = dato.horasalida;
        document.getElementById('U_tolerancia').value = dato.tolerancia;
        document.getElementById('U_estado').value = dato.estado;
        document.getElementById('id_tu').value = dato.id;

    }
</script>

<script>
    function actualizarHoraSalida() {
        // Obtén el valor de la hora de entrada
        var horaEntrada = document.getElementById('hent').value;

        // Actualiza el campo de hora de salida para que no permita horas anteriores
        document.getElementById('hsal').min = horaEntrada;
    }
</script>

<script>
    function actualizarHoraSalidaEditar() {
        // Obtén el valor de la hora de entrada en el modal editar
        var horaEntradaEditar = document.getElementById('U_hent').value;

        // Actualiza el campo de hora de salida en el modal editar para que no permita horas anteriores
        document.getElementById('U_hsal').min = horaEntradaEditar;
    }
</script>




<script>
    let table = new DataTable('#table_turno', {
    language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
			     },
			     "sProcessing":"Procesando...",
            }   ,
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				className: 'btn btn-success'
			},
			{
				extend:    'pdfHtml5',
				text:      '<i class="fas fa-file-pdf"></i> ',
				titleAttr: 'Exportar a PDF',
				className: 'btn btn-danger',
                orientation: 'landscape' 
			},
			{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',
				titleAttr: 'Imprimir',
				className: 'btn btn-info'
			},
		]	      

});       
</script>


<?php 

include_once('src/components/parte_inferior.php');
?>
