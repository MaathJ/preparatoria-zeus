<?php
//include_once('auth.php');
include('config/conexion.php');
include_once('src/components/parte_superior.php');
?>

<style type="text/css">
    .usuar {
        display: flex;
    }

    .icono {
        cursor: pointer;
    }

    td {
        padding: 10px;
    }
</style>
<div class="container-page">
    <div>
        <p>Zeus<span>/Usuario</span></p>
        <h3>Usuario</h3>
    </div>

    <div class="container-table" style="background-color: #fff;">
        <table class="table table-striped" id="table_usuario">
            <thead align="center" style="color: #fff; background-color:#010133;">
                <tr align="center">
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Nombre y Apellido</th>
                    <th>Dni</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Opciones</th>
                </tr>

            </thead>
            <tbody>
                <?php

                $sqlu = "SELECT u.* , ro.* FROM  usuario u inner join rol ro
                                       on u.id_ro = ro.id_ro order by u.id_us DESC ";
                $f = mysqli_query($cn, $sqlu);

                while ($r = mysqli_fetch_assoc($f)) {


                ?>

                    <tr align="center">
                        <td><?php echo $r['id_us'] ?> </td>
                        <td><?php echo $r['usuario_us'] ?></td>
                        <td><?php echo $r['contra_us'] ?></td>
                        <td><?php echo $r['nombre_us'] . " " . $r['apellido_us']  ?></td>
                        <td><?php echo $r['dni_us'] ?></td>
                        <td><?php echo $r['telefono_us'] ?></td>
                        <td align="center"><?php
                                            $estado = $r['estado_us'];
                                            $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                            echo $button;
                                            ?>
                        </td>
                        <td><?php echo $r['nombre_ro'] ?></td>
                        <td>
                            <center>
                                <a class="btn btn-lg btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" onclick="cargar_info({
                                            'usuario': '<?php echo $r['usuario_us'] ?? ''; ?>',
                                            'pass': '<?php echo $r['contra_us'] ?? ''; ?>',
                                            'nombre': '<?php echo $r['nombre_us'] ?? ''; ?>',
                                            'telefono': '<?php echo $r['telefono_us'] ?? ''; ?>',
                                            'estado': '<?php echo $r['estado_us'] ?? ''; ?>',
                                            'rol': '<?php echo $r['id_ro'] ?? ''; ?>',
                                            'id': '<?php echo $r['id_us'] ?? ''; ?>',
                                            'apellido': '<?php echo $r['apellido_us'] ?? ''; ?>',
                                            'dni': '<?php echo $r['dni_us'] ?? ''; ?>',
                                            
                                                });">
                                    <i class="fas fa-edit"> </i></a>



                                <a class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#ModalEliminar" data-bs-whatever="@mdo" onclick="cargarinfo2({
                                                'usuario2': '<?php echo $r['id_us'] ?? ''; ?>',
                                            
                                                });"><i class="fas fa-trash"></i></a>

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










<div class="modal fade  " id="ModalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #952513; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">CONFIRMAR ELIMINACION DE USUARIO:</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/usuario/D_usuario.php" method="post">

                    <iv class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5>¿Está seguro que desea eliminar el usuario?</h5>
                                <input type="text" name="cod_usu2" id="cod_us" class="form-control" hidden>
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








<div class="modal fade  " id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="color: #fff; background-color:#0A1048;">
            </div>
            <div class="modal-body">
                <form action="usuario/U_usuario.php" method="post">

                    <div class="row">


                        <div class="col-md-12">
                            <h5 style="color: #1A3B81;">Datos personales del Usuario</h5>
                            <br>
                            <table width="100%" cellspacing="10">
                                <tr>
                                    <td style="width: 10px">
                                        <label for="nombre" class="col-form-label" style="color: black;">Nombre:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtnombre" placeholder="Ingrese el nombre completo" maxlength="50" class="form-control" id="nombre" required>
                                    </td>
                                    <td>
                                        <label for="nombre" class="col-form-label" style="color: black;">Apellido:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtapellido2" placeholder="Ingrese el apellido completo" maxlength="50" class="form-control" id="apellido2" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="nombre" class="col-form-label" style="color: black;">DNI:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtdni2" placeholder="Ingrese el dni completo" maxlength="50" class="form-control" id="dni2" required>
                                    </td>
                                    <td>
                                        <label for="telefono" class="col-form-label" style="color: black;">Telefono:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txttelefono" placeholder="Ingrese 9 digitos" class="form-control" id="telefono" required maxlength="9">
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <div class="col-md-12">
                            <h5 style="color: #1A3B81;">Datos especificos del Usuario</h5>
                            <br>
                            <table style="width: 100%">
                                <tr>
                                    <td><label for="usuario" class="col-form-label" style="color: black;">Usuario:</label></td>
                                    <td>
                                        <input type="text" name="txtusuario" placeholder="Ingrese el usuario" class="form-control" id="usuario" required>
                                        <input type="text" name="id_usu2" placeholder="Ingrese el usuario" class="form-control" id="id_usu2" hidden>
                                    </td>

                                    <td>
                                        <label for="pass" class="col-form-label" style="color: black;">Contraseña:</label>
                                    </td>
                                    <td>
                                        <div class="usuar">
                                            <input type="password" name="txtpass" placeholder="Ingrese su contraseña" class="form-control" id="pass2" required><img src="src/assets/images/candado.png" class="icono" width="20px" style="margin-top: 10px;" height="20px" onclick="mostrarContrasena()">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="usuario" class="col-form-label" style="color: black;">Confirmar:</label></td>
                                    <td>
                                        <div class="usuar">
                                            <input type="password" name="txtpass" placeholder="Ingrese su contraseña" class="form-control" id="pass2" required><img src="src/assets/images/candado.png" class="icono" width="20px" style="margin-top: 10px;" height="20px" onclick="mostrarContrasena()">
                                        </div>
                                        <p id="" style="display: none;">Corregir No es igual a la contraseña</p>

                                    </td>
                                    <td><label for="rol" class="col-form-label" style="color: black;">Rol:</label></td>
                                    <td><select class="form-select form-select-sm mb-3" name="lstrol" id="rol22" required>
                                            <option value="" disabled>Selecciona un rol</option>
                                            <?php
                                            $sql = "SELECT * FROM rol";
                                            $f = mysqli_query($cn, $sql);


                                            while ($r = mysqli_fetch_assoc($f)) {
                                            ?>
                                                <option value="<?php echo $r['id_ro'] ?>"><?php echo $r['nombre_ro'] ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <label for="estado" class="col-form-label" style="color: black;">Estado:</label></td>
                                    <td><select class="form-select form-select-sm mb-3" name="lstestado" id="estado" required>

                                            <option value="" disabled selected>Selecciona un Estado</option>
                                            <option value="ACTIVO" require>ACTIVO</option>
                                            <option value="INACTIVO">INACTIVO</option>

                                        </select> </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="">Editar</button>
                        <input type="hidden" name="id_us" id="id_us" value="">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade  " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h6 class="modal-title" id="exampleModalLabel">Agregar registro de Usuario:</h6>
            </div>
            <div class="modal-body">
                <form action="usuario.php" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 style="color: #1A3B81;">Datos personales del Usuario</h5>
                            <br>
                            <table width="100%" cellspacing="10">
                                <tr>
                                    <td style="width: 10px">
                                        <label for="nombre" class="col-form-label" style="color: black;">Nombre:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtnombre" placeholder="Ingrese el nombre completo" maxlength="50" class="form-control" id="nombre" required>
                                    </td>
                                    <td>
                                        <label for="nombre" class="col-form-label" style="color: black;">Apellido:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtapellido" placeholder="Ingrese el apellido completo" maxlength="50" class="form-control" id="apellido" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="telefono" class="col-form-label" style="color: black;">DNI:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtdni" placeholder="Ingrese 9 digitos" class="form-control" id="telefono" required maxlength="9">
                                    </td>
                                    <td>
                                        <label for="telefono" class="col-form-label" style="color: black;">Telefono:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txttelefono" placeholder="Ingrese 9 digitos" class="form-control" id="telefono" required maxlength="9">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <h5 style="color: #1A3B81;">Datos especificos del Usuario</h5>
                            <br>
                            <table style="width: 100%">
                                <tr>
                                    <td><label for="usuario" class="col-form-label" style="color: black;">Usuario:</label></td>
                                    <td><input type="text" name="txtusuario" placeholder="Ingrese el usuario" class="form-control" id="usuario" required></td>
                                    <td><label for="pass" class="col-form-label" style="color: black;">Contraseña:</label></td>
                                    <td>
                                        <div class="usuar">
                                            <input type="password" name="txtpass" placeholder="Ingrese su contraseña" class="form-control" id="pass" required><img src="src/assets/images/candado.png" class="icono" width="20px" style="margin-top: 10px;" height="20px" onclick="mostrarContrasena3()">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="usuario" class="col-form-label" style="color: black;">Confirmar:</label></td>
                                    <td>
                                        <div class="usuar">
                                            <input type="password" name="txtconfpass" placeholder="Repita su contraseña" class="form-control" id="Confpass" required><img src="src/assets/images/candado.png" class="icono" width="20px" style="margin-top: 10px;" height="20px" onclick="mostrarContrasena4()">
                                        </div>
                                        <p id="corrector" style="display: none;">Corregir No es igual a la contraseña</p>
                                        <p id="Bueno" style="display: none;">Corregir No es igual a la contraseña</p>

                                    </td>
                                    <td><label for="rol" class="col-form-label" style="color: black;">Rol:</label></td>
                                    <td><select class="form-select form-select-sm mb-6" name="lstrol" id="rol" style="width: 100%;" required>

                                            <option value="" disabled selected>Selecciona un rol</option>

                                            <?php
                                            $sql = "SELECT * FROM rol";
                                            $f = mysqli_query($cn, $sql);
                                            while ($r = mysqli_fetch_assoc($f)) {
                                            ?>
                                                <option value="<?php echo $r['id_ro'] ?>"><?php echo $r['nombre_ro'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
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
</div>

<script>
    const pass = document.getElementById('pass');
    const confpass = document.getElementById('Confpass');
    const corrector = document.getElementById('corrector');
    const btnregistrar = document.getElementById('registrar');

    confpass.addEventListener('input', verificar);

    function verificar() {
        if (pass.value === confpass.value) {

            corrector.style.display = 'none';
            btnregistrar.style.display = 'block';

        } else {
            corrector.style.display = 'block';
            corrector.style.color = 'red';
            btnregistrar.style.display = 'none';
        }
    }
</script>
<script>
    function mostrarContrasena3() {
        var inputPass = document.getElementById("pass");

        if (inputPass.type === "password") {
            inputPass.type = "text";
        } else {
            inputPass.type = "password";
        }
    }

    function mostrarContrasena4() {
        var inputPass = document.getElementById("Confpass");

        if (inputPass.type === "password") {
            inputPass.type = "text";
        } else {
            inputPass.type = "password";
        }
    }

    function mostrarContrasena() {
        var inputPass = document.getElementById("pass2");

        if (inputPass.type === "password") {
            inputPass.type = "text";
        } else {
            inputPass.type = "password";
        }
    }

    function mostrarContrasena2() {
        var inputPass = document.getElementById("Confpass2");

        if (inputPass.type === "password") {
            inputPass.type = "text";
        } else {
            inputPass.type = "password";
        }
    }

    function cargarinfo2(data) {
        document.getElementById('cod_us').value = data.usuario2;
    }

    function cargar_info(dato) {

        document.getElementById('usuario').value = dato.usuario;
        document.getElementById('pass2').value = dato.pass;
        document.getElementById('Confpass2').value = dato.pass;
        document.getElementById('nombre').value = dato.nombre;
        document.getElementById('telefono').value = dato.telefono;
        document.getElementById('rol').value = dato.rol;
        document.getElementById('id_us').value = dato.id;
        document.getElementById('apellido2').value = dato.apellido;
        document.getElementById('dni2').value = dato.dni;
        document.getElementById('id_usu2').value = dato.id;



        var generoSelect = document.getElementById('rol22');

        for (var i = 0; i < generoSelect.options.length; i++) {
            if (generoSelect.options[i].value == dato.rol) {
                generoSelect.options[i].selected = true;
                break;
            }
        }


        var generoSelect = document.getElementById('estado');

        for (var i = 0; i < generoSelect.options.length; i++) {
            if (generoSelect.options[i].value == dato.estado) {
                generoSelect.options[i].selected = true;
                break;
            }
        }


    }
    $(document).ready(function() {
        $('#rol').on('change', function() {
            var idRolSeleccionado = $(this).find(':selected').data('id-rol');

            $('#id_rol_seleccionado').val(idRolSeleccionado);
        });
    });
</script>
<script>
    document.getElementById('rol').addEventListener('change', function() {
        var selectedValue = this.value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {}
        };
        xhr.open('GET', 'usuario.php?selectedValue=' + selectedValue, true);
        xhr.send();
    });
</script>


<?php
if (
    isset($_GET['txtusuario']) &&
    isset($_GET['txtpass']) &&
    isset($_GET['txtconfpass']) &&
    isset($_GET['txtnombre']) &&
    isset($_GET['txtapellido']) &&
    isset($_GET['txtdni']) &&
    isset($_GET['txttelefono']) &&
    isset($_GET['lstrol'])
) {
    $user = strtoupper($_GET['txtusuario']);
    $pass = strtoupper($_GET['txtpass']);
    $confpass = strtoupper($_GET['txtconfpass']);
    $nombre = strtoupper($_GET['txtnombre']);
    $apellido = strtoupper($_GET['txtapellido']);
    $dni = strtoupper($_GET['txtdni']);
    $telefono = $_GET['txttelefono'];
    $rol = strtoupper($_GET['lstrol']);


    if ($pass !== $confpass) {
        header('location:usuario.php?error=Las contraseñas no coinciden');
    }

    include('conexion.php');

    $sql = "INSERT INTO usuario (usuario_us, contra_us, nombre_us, apellido_us, telefono_us, dni_us, estado_us, id_ro) VALUES ('$user', '$pass', '$nombre', '$apellido','$telefono','$dni', 'ACTIVO', '$rol')";
    $f = mysqli_query($cn, $sql);

    if ($f) {

        echo '<script>window.location.href = "usuario.php";</script>';
    } else {
        echo '<script>window.location.href = "usuario.php";</script>';
    }
}
?>

<script>
    let table = new DataTable('#table_usuario', {
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                orientation: 'landscape'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]

    });
</script>

<?php
include_once('src/components/parte_inferior.php');
?>