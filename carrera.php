<?php
include_once('auth.php');
include('config/conexion.php');
include_once("src/components/parte_superior.php");

?>


<link rel="stylesheet" src="style.css" href="./bootstrap/bootstrap.css">
<link rel="stylesheet" src="style.css" href="./datatables/datatables.css">


<div class="container-page">

    <div>
        <p>Zeus<span>/Carrera</span></p>
        <h3>Carrera</h3>

    </div>
    <button type="button" class="periodo btn btn-primary " style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
        Registrar
    </button>


    <div class="container-table" style="background-color: #fff;">


        <div class="col-md-12">


            <table class="table table-striped" id="table_carrera">
                <thead align="center" class="" style="color: #fff; background-color:#010133;">
                    <tr>

                        <th class="text-center">Nombre</th>
                        <th class="text-center">Area</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlc = "SELECT ca.*, ar.*
                                            FROM carrera as ca
                                            INNER JOIN area ar ON ca.id_ar = ar.id_ar   ";
                    $resultadocar = mysqli_query($cn, $sqlc);

                    while ($filaca = mysqli_fetch_assoc($resultadocar)) {
                    ?>
                        <tr>

                            <td class="text-center"><?php echo $filaca['nombre_ca']; ?></td>
                            <td class="text-center"><?php echo $filaca['nombre_ar']; ?></td>
                            <td align="center">


                                <?php
                                $estado = $filaca['estado_ca'];
                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                echo $button;
                                ?>



                            </td>

                            <td>

                                <a class="btn btn-lg btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                            
                            'carrera': '<?php echo isset($filaca['nombre_ca']) ? $filaca['nombre_ca'] : ''; ?>',
                              'area': '<?php echo isset($filaca['id_ar']) ? $filaca['id_ar'] : ''; ?>',
                                 
                                 'estado': '<?php echo isset($filaca['estado_ca']) ? $filaca['estado_ca'] : ''; ?>',
                                  'id_ca': '<?php echo isset($filaca['id_ca']) ? $filaca['id_ca'] : ''; ?>',
                                    });">
                                    <i class="fas fa-edit"> </i></a>



                                <!-- Agregar el atributo data-bs-toggle y data-bs-target para abrir el modal -->
                                <a href="#" class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="<?php echo $filaca['id_ca']; ?>">
                                    <i class="fas fa-trash"></i>
                                </a>


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


<!-- Page-body end -->

<div id="styleSelector"> </div>




<!-- MODAL PARA EDITAR Usuario  -->
<div class="modal fade " id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header "  style="background-color: #010133; color: #ffffff;">
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
            <div class="modal-header"  style="background-color: #010133; color: #ffffff;">
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
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"  style="background-color: #010133; color: #ffffff;" >
                <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
               
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta carrera?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Agregar el atributo data-id al botón para almacenar el ID del turno -->
                <a href="#" class="btn btn-danger" id="confirmarEliminar" data-id="">
                    Confirmar Eliminar
                </a>
            </div>
        </div>
    </div>
</div>


<script>
    // Manejar el evento de clic en el botón de eliminar del modal
    $(document).on('click', '#confirmarEliminar', function() {
        // Obtener el ID del turno
        var id_ca = $(this).data('id');
        // Redirigir a la página de eliminación con el ID del turno
        window.location.href = 'app/controllers/carrera/D_carrera.php?cod=' + id_ca;
    });

    // Actualizar el ID del turno en el modal al abrirse
    $(document).on('show.bs.modal', '#modalConfirmarEliminar', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id_ca = button.data('id'); // Extraer la información de los atributos data-*
        var modal = $(this);
        // Actualizar el atributo data-id del botón de confirmarEliminar con el ID del turno
        modal.find('#confirmarEliminar').data('id', id_ca);
    });
</script>

<script>
    function cargar_info(dato) {

        document.getElementById('U_area').value = dato.area;
        document.getElementById('U_carrera').value = dato.carrera;
        document.getElementById('U_estado').value = dato.estado;
        document.getElementById('id_ca').value = dato.id_ca;

    }
</script>

<?php
include_once("src/components/parte_inferior.php")
?>



<script src="src/assets/js/datatableIntegration.js"></script>

<script>initializeDataTable('#table_carrera');</script>

<!-- Recibiendo por metodo post el formulario  -->

<?php
if (
    isset($_POST['txtcarrera']) &&

    isset($_POST['lstarea'])


) {

    $carrera = $_POST['txtcarrera'];

    $area = $_POST['lstarea'];


    include('config/conexion.php');



    $sql = "INSERT INTO carrera (nombre_ca,  estado_ca, id_ar) VALUES ('$carrera',  'ACTIVO','$area')";
    $f = mysqli_query($cn, $sql);

    if ($f) {
        // Redirigir a la misma vista con un mensaje de éxito
        echo '<script>window.location.href = "carrera.php";</script>';
    } else {
        // Redirigir a la misma vista con un mensaje de error
        echo '<script>window.location.href = "carrera.php";</script>';
    }
}
?>