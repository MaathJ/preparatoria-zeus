<?php

include_once('auth.php');
include('config/conexion.php');
include_once("src/components/parte_superior.php");

?>


<link rel="stylesheet" src="style.css" href="./bootstrap/bootstrap.css">
<link rel="stylesheet" src="style.css" href="./datatables/datatables.css">


            <div class="container-page">
                    <div>
                            <p>Zeus<span>/Area</span></p>
                            <h3>Area</h3>

                    </div>
                                
                                    <button type="button" class="periodo btn btn-primary " style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                                    Registrar
                                    </button>

              <div class="container-table" style="background-color: #fff;">   
                        <div class="col-md-12">
                        <table class="table table-striped" id="table_area">
                    <thead align="center" class="" style="color: #fff; background-color:#010133;">
                        <tr>
                          
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlarea = "SELECT * FROM area ORDER BY id_ar DESC";
                        $resultadoarea = mysqli_query($cn, $sqlarea);

                        while ($filar = mysqli_fetch_assoc($resultadoarea)) {
                        ?>
                            <tr>
                                
                                
                                <td class="text-center"><?php echo $filar['nombre_ar']; ?></td>
                                <td align="center">
                                    
                                
                                
                                                 <?php
                                                $estado = $filar['estado_ar'];
                                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                                echo $button;
                                                ?>
                            
                            
                                </td>

                                <td class="text-center">
                                <a class="btn btn-lg btn-primary btn-circle"  data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent"  onclick="cargar_info({
                            
                              'area': '<?php echo isset($filar['nombre_ar']) ? $filar['nombre_ar'] : ''; ?>',
                                 
                                 'estado': '<?php echo isset($filar['estado_ar']) ? $filar['estado_ar'] : ''; ?>',
                                  'id': '<?php echo isset($filar['id_ar']) ? $filar['id_ar'] : ''; ?>',
                                    });">
                                 <i class="fas fa-edit"> </i></a>


                                    <!-- Agregar el atributo data-bs-toggle y data-bs-target para abrir el modal -->
                                    <a href="#" class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="<?php echo $filar['id_ar']; ?>">
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
    <!-- Page-body end -->
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
    <!-- Page-body end -->
</div>


<!-- MODAL PARA CONFIRMAR ELIMINACIÓN -->
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;" >
                <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta area?
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
    $(document).on('click', '#confirmarEliminar', function () {
        // Obtener el ID del turno
        var id_ar = $(this).data('id');
        // Redirigir a la página de eliminación con el ID del turno
        window.location.href = 'app/controllers/area/D_area.php?cod=' + id_ar;
    });

    // Actualizar el ID del turno en el modal al abrirse
    $(document).on('show.bs.modal', '#modalConfirmarEliminar', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id_ar = button.data('id'); // Extraer la información de los atributos data-*
        var modal = $(this);
        // Actualizar el atributo data-id del botón de confirmarEliminar con el ID del turno
        modal.find('#confirmarEliminar').data('id', id_ar);
    });
</script>




<script>
    function cargar_info(dato) {
        
        document.getElementById('U_area').value = dato.area;
        document.getElementById('U_estado').value = dato.estado;
        document.getElementById('id_ar').value = dato.id;

    }
</script>

<?php
include_once("src/components/parte_inferior.php")
?>

<script src="src/assets/js/datatableIntegration.js"></script>

<script>initializeDataTable('#table_area');</script>


<!-- Recibiendo por metodo post el formulario  -->

<?php
    if (
        isset($_POST['txtarea'])
       
        
    ) {
        $area = $_POST['txtarea'];
        // $estado = $_POST['lstestado'];

        include('config/conexion.php');

        $sql = "INSERT INTO area (nombre_ar,  estado_ar) VALUES ('$area',  'ACTIVO')";
        $f = mysqli_query($cn, $sql);

        if ($f) {
            // Redirigir a la misma vista con un mensaje de éxito
            // header('Location:area.php');
            echo '<script>window.location.href = "area.php";</script>';
        } else {
            // Redirigir a la misma vista con un mensaje de error
            // header('Location:area.php');
            echo '<script>window.location.href = "area.php";</script>';
        }
    }
?>
