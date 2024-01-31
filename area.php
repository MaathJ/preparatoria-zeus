<?php

include_once('auth.php');
include('config/conexion.php');
include_once("src/components/parte_superior.php");
include('modales_area.php');
?>

<div class="container-page">
    <div>
        <p>Zeus<span>/Area</span></p>
        <h3>Area</h3>
    </div>
    <button type="button" class="periodo btn btn-primary " style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
        Registrar
    </button>
    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-striped" id="table_area" id="table_area" style="width:100%; box-sizing: border-box; overflow:hidden">
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
                        <?php 
                        deleteModalArea($filar['id_ar']);
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
                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                            
                              'area': '<?php echo isset($filar['nombre_ar']) ? $filar['nombre_ar'] : ''; ?>',
                                 
                                 'estado': '<?php echo isset($filar['estado_ar']) ? $filar['estado_ar'] : ''; ?>',
                                  'id': '<?php echo isset($filar['id_ar']) ? $filar['id_ar'] : ''; ?>',
                                    });">
                                    <i class="fas fa-edit"> </i></a>

                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalArea<?php echo $filar['id_ar']; ?>">
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





<!-- 
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
</script> -->




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

<script>
    initializeDataTable('#table_area');
</script>


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