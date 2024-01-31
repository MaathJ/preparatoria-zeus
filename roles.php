<?php
include_once('auth.php');
include('config/conexion.php');
include_once('src/components/parte_superior.php');
?>

<link rel="icon" href="src/assets/images/logo-zeus.png">
<style type="text/css">
    td {
        padding: 10px;
    }
</style>
<div class="container-page">
    <div>
        <p>Zeus<span>/Roles</span></p>
        <h3>Roles</h3>

    </div>
    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalrolRegistro" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>
    <div class="container-table" style="background-color: #fff;">
    <div class="col-md-12">
        <table class="table table-striped" id="table_rol">
            <thead align="center" style="color: #fff; background-color:#010133;">
                <tr>
                    
                    <th>ROL</th>
                    <th>ESTADO</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT * FROM rol as r";
                $f = mysqli_query($cn, $sql);
                while ($r = mysqli_fetch_assoc($f)) {


                ?>
                    <tr>
                        
                        <td>
                            <center><?php echo $r['nombre_ro'] ?></center>
                        </td>
                        <td align="center"><?php
                                            $estado = $r['estado_ro'];
                                            $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                            echo $button;
                                            ?>
                        </td>
                        <td>
                            <center>
                                <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalrolEditar" data-bs-whatever="@mdo" onclick=" cargar_info({
                                                'id':' <?php echo $r['id_ro'] ?? ''; ?> ',
                                                'nombre':'<?php echo $r['nombre_ro'] ?? ''; ?>',
                                                'estado':'<?php echo $r['estado_ro'] ?? ''; ?>'
                                            } )">
                                    <i class="fas fa-edit"> </i></a>
                                <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#ModalEliminar" data-bs-whatever="@mdo" onclick=" cargar_info2({
                                                'id':' <?php echo $r['id_ro'] ?? ''; ?> ',
                                            } )"><i class="fas fa-trash"> </i></a>
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













<div class="modal fade  " id="ModalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header "style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">CONFIRMAR ELIMINACION DEL ROL:</h4>

                
              
            </div>
            <div class="modal-body">
                <form action="app/controllers/rol/D_rol.php" method="post">

                    
                           
                                <h5 class="modal-title" id="exampleModalLabel">¿Está seguro que desea eliminar el rol?</h5>
                                <input type="text" name="cod_rol2" id="cod_rol2" class="form-control" hidden>
                           

                
                    <div class="modal-footer">
                        <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-danger" id="">ELIMINAR</button>
                        <input type="hidden" name="id_us" id="id_us" value="">

                    </div>
                </form>
            </div>



        </div>
    </div>
</div>





<!-- MODAL PARA EDITAR ROLES  -->
<div class="modal fade  " id="ModalrolEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">EDITAR TIPO ROL</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/rol/U_rol.php" method="post">
                    <div class="col-12">
                        <label for="rol" class="form-label">Rol:</label>
                        <input type="text" name="rol" placeholder="Ingrese el Rol" class="form-control" id="rol" required>
                        <input type="text" name="codigo" class="form-control" id="cod" hidden>
                        
                    </div>
                    <div class="col-12">
                        <label for="genero-name" class="form-label" >Estado:</label>
                        <select  name="lstestado" id="Genero_name2" class="form-control" aria-label="Default select example">
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">Registrar</button>
                        <input type="hidden" name="id_us" id="id_ro" value="">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<!-- MODAL PARA REGISTRO ROLES  -->
<div class="modal fade  " id="ModalrolRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="color: #fff; background-color:#0A1048;">
                <h4 class="modal-title" id="exampleModalLabel">REGISTRO ROL:</h4>
            </div>
            <div class="modal-body">


                <form action="roles.php" method="get">
                    
                       
                            <div class="col-12">
                                <label for="rol" class="form-label" style="color: black;">Rol:</label>
                                <input type="text" name="rol" placeholder="Ingrese el Rol" class="form-control" id="rol" required>
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

<script>
    function cargar_info2(dato) {

        document.getElementById('cod_rol2').value = dato.id;
    }


    function cargar_info(dato) {

        document.getElementById('cod').value = dato.id;

        document.getElementById('rol').value = dato.nombre;

        document.getElementById('id_ro').value = dato.id;

        var generoSelect = document.getElementById('Genero_name2');

        for (var i = 0; i < generoSelect.options.length; i++) {
            if (generoSelect.options[i].value == dato.estado) {
                generoSelect.options[i].selected = true;
                break;
            }
        }


    }

</script>

<?php

if (isset($_GET['rol'])) {

    $rol = strtoupper($_GET['rol']);


    $sqlrol = "INSERT INTO rol VALUES('0','$rol', 'ACTIVO')";
    mysqli_query($cn, $sqlrol);

    echo '<script>window.location.href = "roles.php";</script>';
}

?>



<?php

include_once('src/components/parte_inferior.php');
?>

<script src="src/assets/js/datatableIntegration.js"></script>

<script>initializeDataTable('#table_rol');</script>