<?php
include_once('auth.php');
include('config/conexion.php');
include_once("src/components/parte_superior.php");
include('modales_carrera.php');
?>
<link rel="icon" href="src/assets/images/logo-zeus.png">
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
                                            INNER JOIN area ar ON ca.id_ar = ar.id_ar";
                    $resultadocar = mysqli_query($cn, $sqlc);

                    while ($filaca = mysqli_fetch_assoc($resultadocar)) {
                    ?>
                        <?php
                        deleteModalCarrera($filaca['id_ca'])
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
                                <a href="#" class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#DeleteModalCarrera<?php echo $filaca['id_ca']; ?>">
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

<script>
    initializeDataTable('#table_carrera');
</script>

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