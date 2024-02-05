<?php
include_once('auth.php');
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

<link rel="icon" href="src/assets/images/logo-zeus.png">

<div class="container-page">
    <div>
        <p>Zeus<span>/Usuario</span></p>
        <h3>Usuario</h3>
    </div>
    <?php
    if ($_SESSION["usuario"]) {
        $id_rol = $_SESSION["rol_usuario"];
        if ($id_rol === "ADMINISTRADOR") {
    ?>
            <button class="usuario-admin btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalRegistrar" data-bs-whatever="@mdo">
                Registrar
            </button>
        <?php
        }
        ?>
    <?php
    }
    ?>


<div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-striped table_id" id="table_usuario" style="width:100%; box-sizing: border-box; overflow:hidden">
                <thead align="center" style="color: #fff; background-color:#010133;">
                    <tr align="center">
                        <th class="text-center">Usuario</th>
                        <th class="text-center">Contraseña</th>
                        <th class="text-center">Nombre y Apellido</th>
                        <th class="text-center">DNI</th>
                        <th class="text-center">Celular</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Rol</th>
                        <th class="text-center">Opciones</th>
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
                                    <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-whatever="@mdo" onclick="cargar_editar({
                                                'usuario': '<?php echo $r['usuario_us'] ?? ''; ?>',
                                                'pass': '<?php echo $r['contra_us'] ?? ''; ?>',
                                                'nombre_us': '<?php echo $r['nombre_us'] ?? ''; ?>',
                                                'telefono': '<?php echo $r['telefono_us'] ?? ''; ?>',
                                                'estado': '<?php echo $r['estado_us'] ?? ''; ?>',
                                                'rol': '<?php echo $r['id_ro'] ?? ''; ?>',
                                                'id': '<?php echo $r['id_us'] ?? ''; ?>',
                                                'apellido': '<?php echo $r['apellido_us'] ?? ''; ?>',
                                                'dni': '<?php echo $r['dni_us'] ?? ''; ?>',
                                                    });">
                                        <i class="fas fa-edit"> </i></a>



                                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#ModalEliminar" data-bs-whatever="@mdo" onclick="cargarinfo2({
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                <h4 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h4>
            </div>
            <div class="modal-body">
                <form action="app/controllers/usuario/D_usuario.php" method="post">
                    
                     ¿Está seguro que desea eliminar el usuario seleccionado?
                    <input type="text" name="cod_usu2" id="cod_us" class="form-control" hidden>
            
                        <input type="hidden" name="id_rol_seleccionado" id="id_rol_seleccionado" value="">
                        <button type="submit" class="btn btn-danger" id="">ELIMINAR</button>
                        <input type="hidden" name="id_us" id="id_us" value="">
                    
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade  " id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="color: #fff; background-color:#0A1048;">
                <h3 class="modal-title" id="exampleModalLabel">EDITAR USUARIO</h3>
            </div>
            <div class="modal-body">
                <form action="app/controllers/usuario/U_usuario.php" method="post">

                    <div class="row">


                        <div class="col-md-12">
                            <h5 style="color: #1A3B81;">Datos personales del Usuario</h5>
                            <br>
                            <table width="100%" cellspacing="10">
                                <tr>
                                    <td style="width: 10px">
                                        <label class="col-form-label" style="color: black;">Nombre:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtnombre" placeholder="Ingrese el nombre completo" maxlength="50" class="form-control" id="U-nombre" required>
                                    </td>
                                    <td>
                                        <label for="nombre" class="col-form-label" style="color: black;">Apellido:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtapellido2" placeholder="Ingrese el apellido completo" maxlength="50" class="form-control" id="U-apellido2" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="nombre" class="col-form-label" style="color: black;">DNI:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txtdni2" placeholder="Ingrese el dni completo" maxlength="50" class="form-control" id="U-dni2" required>
                                    </td>
                                    <td>
                                        <label for="telefono" class="col-form-label" style="color: black;">Celular:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txttelefono" placeholder="Ingrese 9 digitos" class="form-control" id="U-telefono" required maxlength="9">
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <div class="col-md-12">
                            <h5 style="color: #1A3B81;">Datos específicos del Usuario</h5>
                            <br>
                            <table style="width: 100%">
                                <tr>
                                    <td><label for="usuario" class="col-form-label" style="color: black;">Usuario:</label></td>
                                    <td>
                                        <input type="text" name="txtusuario" placeholder="Ingrese el usuario" class="form-control" id="U-usuario" required>
                                        <input type="text" name="id_usu2" placeholder="Ingrese el usuario" class="form-control" id="U-id_usu2" hidden>
                                    </td>

                                    <td>
                                        <label for="pass" class="col-form-label" style="color: black;">Contraseña:</label>
                                    </td>
                                    <td>
                                        <div class="usuar">
                                            <input type="password" name="txtpass" placeholder="Ingrese su contraseña" class="form-control" id="U-pass2" required><img src="src/assets/images/candado.png" class="icono" width="20px" style="margin-top: 10px;" height="20px" onclick="mostrarContrasena()">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="usuario" class="col-form-label" style="color: black;">Confirmar:</label></td>
                                    <td>
                                        <div class="usuar">
                                            <input type="password" name="txtpass" placeholder="Ingrese su contraseña" class="form-control" id="U-Confpass2" required><img src="src/assets/images/candado.png" class="icono" width="20px" style="margin-top: 10px;" height="20px" onclick="mostrarContrasena2()">
                                        </div>
                                        <p id="" style="display: none;">Las contraseñas no coinciden</p>

                                    </td>
                                    <td><label for="rol" class="col-form-label" style="color: black;">Rol:</label></td>
                                    <td><select class="form-control form-select-lm mb-3" name="lstrol" id="U-rol" required>
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
                                    <td><select class="form-control form-select-sm mb-3" name="lstestado" id="U-estado" required>

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

<div class="modal fade  " id="ModalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="color: #fff; background-color:#0A1048;">
                <h3 class="modal-title" id="exampleModalLabel">AGREGAR USUARIO</h3>
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
                                        <label for="telefono" class="col-form-label" style="color: black;">Celular:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="txttelefono" placeholder="Ingrese 9 digitos" class="form-control" id="telefono" required maxlength="9">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <h5 style="color: #1A3B81;">Datos específicos del Usuario</h5>
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
                                        <p id="corrector" style="display: none;">Las contraseñas no coinciden</p>
                                        <p id="Bueno" style="display: none;">Las contraseñas no coinciden</p>

                                    </td>
                                    <td><label for="rol" class="col-form-label" style="color: black;">Rol:</label></td>
                                    <td><select class="form-control form-select-sm mb-6" name="lstrol" id="rol" style="width: 100%;" required>

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
        var inputPass = document.getElementById("U-pass2");

        if (inputPass.type === "password") {
            inputPass.type = "text";
        } else {
            inputPass.type = "password";
        }
    }

    function mostrarContrasena2() {
        var inputPass = document.getElementById("U-Confpass2");

        if (inputPass.type === "password") {
            inputPass.type = "text";
        } else {
            inputPass.type = "password";
        }
    }

    function cargarinfo2(data) {
        document.getElementById('cod_us').value = data.usuario2;
    }

    function cargar_editar(dato) {

        document.getElementById('U-usuario').value = dato.usuario;
        document.getElementById('U-pass2').value = dato.pass;
        document.getElementById('U-Confpass2').value = dato.pass;
        document.getElementById('U-nombre').value = dato.nombre_us;
        document.getElementById('U-telefono').value = dato.telefono;
        document.getElementById('U-rol').value = dato.rol;
        document.getElementById('U-apellido2').value = dato.apellido;
        document.getElementById('U-dni2').value = dato.dni;
        document.getElementById('U-id_usu2').value = dato.id;
        document.getElementById('U-estado').value = dato.estado;
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



<?php
include_once('src/components/parte_inferior.php');
?>

<script src="src/assets/js/datatableIntegration.js"></script>

<script>
$(document).ready(function() {
            var table = $('#table_usuario').DataTable({
                responsive: true,
                language: {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "info": " _TOTAL_ registros",
                    "infoEmpty": "No hay registros para mostrar",
                    "infoFiltered": "(filtrado de _MAX_  registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "sProcessing": "Cargando...",
                },
                dom: 'Bfrtilp',
                buttons: [{
                        extend: 'excelHtml5',
                        autofilter: true,
                        text: '<i class="fa-regular fa-file-excel"></i>',
                        titleAttr: 'Exportar a Excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }

                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i>',
                        titleAttr: 'Exportar a PDF',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        },
                        customize: function(doc) {

                            doc.content[1].table.body[0].forEach(function(h) {
                                h.fillColor = 'rgb(1, 1, 51)';
                            });
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i>',
                        titleAttr: 'Imprimir',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        },

                    },
                ]
            });

            new $.fn.dataTable.FixedHeader(table);
        });
</script>