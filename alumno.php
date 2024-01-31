<?php
include_once('auth.php');
include_once("./src/components/parte_superior.php");
include_once('./config/conexion.php');
include_once('modal_card_alumno.php');
include('modales_alumno.php');
?>
<link rel="stylesheet" src="style.css" href="./src/assets/css/alumno/alumno.css">
<link rel="stylesheet" src="style.css" href="./bootstrap/bootstrap.css">
<link rel="stylesheet" src="style.css" href="./datatables/datatables.css">
<link rel="icon" href="src/assets/images/logo-zeus.png">
<script>
    function infoI(dato) {
        idAlumno = dato;
        console.log(idAlumno);
        $.ajax({
            url: './Alumno/actions/cardinfo.php',
            type: 'POST',
            data: {
                id_alI: idAlumno
            },
            dataType: 'json',
            success: function(data) {
                // Actualizar elementos dentro del modal usando los IDs
                $
                $('#card-user').text(data.nombre);
                $('#card-edad').text(data.edad);
                $('#card-estado').text(data.estado);
                let estadoTexto = $('#card-estado').text().trim();
                if (estadoTexto === 'ACTIVO') {
                    $('#card-estado').css({
                        'color': 'green',
                        'font-weight': 'bold'
                    })
                } else {
                    $('#card-estado').css({
                        'color': 'red',
                        'font-weight': 'bold'
                    })
                }

                $('#card-dni').text(data.dni);
                $('#card-fnac').text(data.fechaNacimiento);
                $('#card-cel').text(data.telefono);
                $('#card-dir').text(data.direccion);
                $('#card-col').text(data.colegio);
                $('#card-uni').text(data.universidad);
                $('#card-napo').text(data.apoderado);
                $('#card-ntel').text(data.telefonoApoderado);
                $('#card-logo-img').attr('src', 'src/assets/images/alumno/' + data.dni + '.jpg');
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });

    }
</script>
<div class="container-page">
    <div>
        <p>Pages<span> / Alumno</span></p>
        <h3>Alumno</h3>
    </div>
    <button class="cliente btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalRegistrar" data-bs-whatever="@mdo">
        Registrar
    </button>
    <div class="container-table" style="background-color: #fff;">
        <div class="col-md-12">
            <table class="table table-striped table_id" id="table_alumno">
                <thead align="center" class="" style="color: #fff; background-color:#010133;">
                    <tr align="center">
                        <!--<th> ID </th>-->
                        <th> FOTO </th>
                        <th> Alumno </th>
                        <th> Edad</th>
                        <th> DNI </th>
                        <th> Telefono </th>
                        <th> Direc. </th>
                        <th> Mas Info</th>
                        <th> Opciones</th>
                </thead>
                <?php
                include('./config/conexion.php');
                $sql = "select * from alumno ";
                $f = mysqli_query($cn, $sql);
                while ($r = mysqli_fetch_assoc($f)) {


                ?>
                    </tr>

                    <!--<td align="center"><?php echo $r['id_al'] ?></td>-->
                    <td align="center"><img class="img-fluid" src="./src/assets/images/alumno/<?php echo $r['dni_al'] ?>.jpg"></td>
                    <td align="center"><?php echo $r['apellido_al'] . ', ' . $r['nombre_al']; ?></td>
                    <td align="center"><?php
                                        $fechaNacimiento = $r['fnac_al'];
                                        // Obtener la fecha actual
                                        $fechaActual = date('Y-m-d');
                                        // Calcular la diferencia entre la fecha actual y la fecha de nacimiento
                                        $diff = date_diff(date_create($fechaNacimiento), date_create($fechaActual));
                                        // Obtener el componente de años de la diferencia
                                        $edad = $diff->format('%Y');
                                        echo $edad;
                                        ?>
                    </td>
                    <td align="center"><?php echo $r['dni_al'] ?></td>
                    <td align="center"><?php echo $r['celular_al'] ?></td>
                    <td align="center"><?php echo $r['direccion_al'] ?></td>
                    <!-- <td align="center"> <?php //echo $r['freg_al'] 
                                                ?></td> -->
                    <td align="center">
                        <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalCardInfo" data-bs-whatever="@mdo" onclick="infoI(
                                                        '<?php echo $r['id_al'] ?? ''; ?>'
                                                    )">
                            Más Info
                        </a>
                    </td>

                    <td>
                        <center>
                            <?php $id_ca = isset($r['id_ca']) ? $r['id_ca'] : null;
                            if ($id_ca !== null) {
                                // Llamar al procedimiento almacenado
                                $stmt = $cn->prepare('CALL ObtenerIdAreaPorIdCarrera(?, @id_ar)');
                                $stmt->bind_param('i', $id_ca);
                                $stmt->execute();

                                // Obtener el resultado
                                $result = $cn->query('select @id_ar AS id_ar');
                                $row = $result->fetch_assoc();
                                $id_arU = $row['id_ar'];
                            } ?>
                            <a class="btn btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info({
                                                        'id_alU': '<?php echo $r['id_al'] ?? ''; ?>',
                                                        'nombreU': '<?php echo $r['nombre_al'] ?? ''; ?>',
                                                        'apellidoU': '<?php echo $r['apellido_al'] ?? ''; ?>',
                                                        'dniU': '<?php echo $r['dni_al'] ?? ''; ?>',
                                                        'celularU': '<?php echo $r['celular_al'] ?? ''; ?>',
                                                        'fnacU': '<?php echo $r['fnac_al'] ?? ''; ?>',
                                                        'ciudadpU': '<?php echo $r['ciudadp_al'] ?? ''; ?>',
                                                        'colegioU': '<?php echo $r['colegio_al'] ?? ''; ?>',
                                                        'universidadU': '<?php echo $r['uni_al'] ?? ''; ?>',
                                                        'direccionU': '<?php echo $r['direccion_al'] ?? ''; ?>',
                                                        'apodU': '<?php echo $r['apoderado_al'] ?? ''; ?>',
                                                        'celapodU': '<?php echo $r['celapod_al'] ?? ''; ?>',
                                                        'idcaU': '<?php echo $r['id_ca'] ?? ''; ?>',
                                                        'idarU': '<?php echo $id_arU; ?>',
                                                        'generoU': '<?php echo $r['genero_al'] ?? ''; ?>'
                                                    });">
                                <i class="fas fa-edit"> </i></a>
                            <a class="btn btn-danger btn-circle " data-bs-toggle="modal" data-bs-target="#ModalEliminarD" data-bs-whatever="@mdo" target="_parent" onclick="cargar_infoD({
                                                'id_alD': '<?php echo $r['id_al'] ?? ''; ?>',
                                                });">
                                <i class="fas fa-trash"> </i></a>
                        </center>

                    </td>

                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>














    <?php

    include_once("./src/components/parte_inferior.php")
    ?>

    <script type="text/javascript">
        /* function validarFormularioAlumnoR() {
                let selectElement = document.getElementById('area-alumno');
                let selectedValue = selectElement.value;

                // Verifica si se ha seleccionado una opción válida
                if (selectedValue == '' || selectedValue == null) {
                    alert('Por favor, selecciona un area y tambien una carrera.');
                    return false; // Evita que el formulario se envíe
                }
                let selectElementc = document.getElementById('carrera-alumno');
                let selectedValuec = selectElementc.value;

                // Verifica si se ha seleccionado una opción válida
                if (selectedValuec == '' || selectedValuec == null) {
                    alert('Por favor, selecciona una carrera.');
                    return false; // Evita que el formulario se envíe
                }
            } */
        // Función para obtener el valor de una cookie
        function getCookie(name) {
            var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            if (match) return match[2];
        }

        // Función para establecer una cookie
        function setCookie(name, value) {
            document.cookie = name + '=' + value + '; path=/';
        }

        // Verificar si la cookie "reloadOnce" está presente
        var reloadOnce = getCookie('reloadOnce');

        if (!reloadOnce) {
            // Si la cookie no está presente, recargar la página y establecer la cookie
            window.onload = function() {
                location.reload(true);
                setCookie('reloadOnce', 'true');
            };
        }



        function cargar_infoD(dato) {
            document.getElementById('id_alumnoD').value = dato.id_alD;

        }


        function cargar_info(dato) {
            // Establecer el valor del área
            $('#Area-alumnoU').val(dato.idarU);
            console.log(dato);
            // Obtener carreras después de establecer el área
            obtenerCarrerasU(dato.idarU, dato.idcaU);

            // Cargar la información restante
            document.getElementById('id_alumnoU').value = dato.id_alU;
            document.getElementById('Apellido-nameU').value = dato.apellidoU;
            document.getElementById('Nombre-nameU').value = dato.nombreU;
            document.getElementById('Dni-nameU').value = dato.dniU;
            document.getElementById('Telefono-nameU').value = dato.celularU;
            document.getElementById('Fenac-alumnoU').value = dato.fnacU;
            document.getElementById('Ciudad-nameU').value = dato.ciudadpU;
            document.getElementById('Colegio-alumnoU').value = dato.colegioU;
            document.getElementById('Direccion-nameU').value = dato.direccionU;
            document.getElementById('Nombrea-alumnoU').value = dato.apodU;
            document.getElementById('Celulara-alumnoU').value = dato.celapodU;

            var generoSelect = document.getElementById('Genero-nameU');

            for (var i = 0; i < generoSelect.options.length; i++) {
                if (generoSelect.options[i].value == dato.generoU) {
                    generoSelect.options[i].selected = true;
                    break;
                }
            }

            var generoSelectUniv = document.getElementById('Universidad-alumnoU');

            for (var i = 0; i < generoSelectUniv.options.length; i++) {
                if (generoSelectUniv.options[i].value == dato.universidadU) {
                    generoSelectUniv.options[i].selected = true;
                    break;
                }
            }

            document.getElementById('img2').src = "./src/assets/images/alumno/" + dato.dniU + ".jpg";
        }



        let table = new DataTable('#table_alumno', {
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
                    text: '<i class="fa-regular fa-file-excel"></i> ',
                    titleAttr: 'Exportar a Excel',
                    // className: 'btn btn-success'
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
                        doc.content[1].margin = [100, 0, 100, 0]
                    },
                },
                {
                    extend: 'print',
                    text: '<i class="fa-solid fa-print"></i>',
                    titleAttr: 'Imprimir',
                    // className: 'btn btn-info'
                },
            ]

        });

        function obtenerCarreras(idArea) {
            console.log(idArea);
            $.ajax({
                url: './Alumno/actions/get_carreras.php',
                type: 'POST',
                data: {
                    id_arU: idArea
                },
                /* dataType: 'json', */ // Indica que esperas datos en formato JSON
                success: function(data) {
                    console.log(data);

                    // Limpiar y llenar las opciones del segundo select (carrera-alumno)
                    $('#carrera-alumno').empty();

                    // Iterar sobre las opciones recibidas y agregarlas al select
                    for (var i = 0; i < data.length; i++) {
                        var option = data[i];
                        // Agregar opción al select
                        $('#carrera-alumno').append($('<option>', {
                            value: option.value,
                            text: option.label
                        }));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                    // Puedes agregar aquí código adicional para manejar el error, como
                }
            });
        }

        function obtenerCarrerasU(idArea, idCaU) {
            console.log(idArea);
            $.ajax({
                url: './Alumno/actions/get_carreras.php',
                type: 'POST',
                data: {
                    id_arU: idArea
                },
                /* dataType: 'json', */ // Indica que esperas datos en formato JSON
                success: function(data) {
                    console.log(data);

                    // Limpiar y llenar las opciones del segundo select (carrera-alumno)
                    $('#Carrera-alumnoU').empty();

                    // Iterar sobre las opciones recibidas y agregarlas al select
                    for (var i = 0; i < data.length; i++) {
                        var option = data[i];
                        // Agregar opción al select
                        $('#Carrera-alumnoU').append($('<option>', {
                            value: option.value,
                            text: option.label
                        }));
                    }
                    if (idCaU != null) {
                        // Establecer el valor del segundo select sin activar el evento 'change'
                        $('#Carrera-alumnoU').val(idCaU);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                    // Puedes agregar aquí código adicional para manejar el error, como
                }
            });
        }

        function limpiarselect(select) {
            $(select).empty();
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Variable para controlar si ya se ha enviado el formulario
            var enviado = false;
            $("#ModalRegistrar form").submit(function(event) {
                // Si ya se ha enviado el formulario, no hacer nada
                if (enviado) {
                    return;
                }

                // Detén el envío del formulario
                event.preventDefault();

                // Obtén el valor del DNI desde el input y recorta espacios
                var dni = $("#Dni-name").val().trim();

                // Realiza la solicitud AJAX
                $.ajax({
                    type: "POST",
                    url: "./Alumno/actions/verificardni.php", // Reemplaza con la ruta correcta a tu script PHP
                    data: {
                        dni: dni
                    }, // Envía solo el DNI
                    success: function(response) {
                        console.log(response);
                        // Maneja la respuesta del servidor
                        if (response == "existe") {
                            // Muestra una alerta indicando que el alumno existe
                            alert("El alumno ya existe. Por favor, revisa el DNI.");

                            // Puedes realizar otras acciones aquí si es necesario
                            // Por ejemplo, cambiar el formato del mensaje de error en tu modal

                            // Mostrar el mensaje de error en tu modal
                            $("#mensajeError").html("El alumno ya existe. Por favor, revisa el DNI.").show();
                        } else {
                            // Si el alumno no existe, realiza la verificación de área y carrera
                            let selectElementArea = document.getElementById('area-alumno');
                            let selectedValueArea = selectElementArea.value;

                            // Verifica si se ha seleccionado una opción válida
                            if (selectedValueArea == '' || selectedValueArea == null) {
                                alert('Por favor, selecciona un área.');
                                return;
                            }

                            let selectElementCarrera = document.getElementById('carrera-alumno');
                            let selectedValueCarrera = selectElementCarrera.value;

                            // Verifica si se ha seleccionado una opción válida
                            if (selectedValueCarrera == '' || selectedValueCarrera == null) {
                                alert('Por favor, selecciona una carrera.');
                                return;
                            }

                            // Marcar el formulario como enviado
                            enviado = true;

                            // Permitir que el formulario se envíe
                            $("#ModalRegistrar form").unbind('submit').submit();
                        }
                    },
                    error: function() {
                        // Maneja errores de la solicitud AJAX
                        alert("Error en la solicitud AJAX.");
                    }
                });
            });


            // Variable para controlar si ya se ha enviado el formulario
            var enviadoEditar = false;

            $("#ModalEditar form").submit(function(event) {
                // Si ya se ha enviado el formulario, no hacer nada
                if (enviadoEditar) {
                    return;
                }

                // Detén el envío del formulario
                event.preventDefault();

                // Obtén el valor del DNI desde el input y recorta espacios
                var dni = $("#Dni-nameU").val().trim();
                var idAlumno = $("#id_alumnoU").val();

                // Realiza la solicitud AJAX
                $.ajax({
                    type: "POST",
                    url: "./Alumno/actions/verificardniU.php", // Reemplaza con la ruta correcta a tu script PHP

                    data: {
                        dni: dni,
                        id_alumno: idAlumno
                    }, // Envía tanto el DNI como el ID del alumno

                    success: function(response) {
                        // Maneja la respuesta del servidor
                        if (response == "existe") {
                            console.log(idAlumno);
                            console.log(dni);
                            console.log(response);
                            console.log('asd');
                            // Muestra una alerta indicando que el alumno ya existe
                            alert("El alumno ya existe. Por favor, revisa el DNI.");

                            // Puedes realizar otras acciones aquí si es necesario
                            // Por ejemplo, cambiar el formato del mensaje de error en tu modal

                            // Mostrar el mensaje de error en tu modal
                            $("#mensajeError").html("El alumno ya existe. Por favor, revisa el DNI.").show();
                        } else {
                            // Si el alumno no existe, realiza la verificación de área y carrera
                            let selectElementArea = document.getElementById('Area-alumnoU');
                            let selectedValueArea = selectElementArea.value;

                            // Verifica si se ha seleccionado una opción válida
                            if (selectedValueArea == '' || selectedValueArea == null) {
                                alert('Por favor, selecciona un área.');
                                return;
                            }

                            let selectElementCarrera = document.getElementById('Carrera-alumnoU');
                            let selectedValueCarrera = selectElementCarrera.value;

                            // Verifica si se ha seleccionado una opción válida
                            if (selectedValueCarrera == '' || selectedValueCarrera == null) {
                                alert('Por favor, selecciona una carrera.');
                                return;
                            }

                            // Marcar el formulario como enviado
                            enviadoEditar = true;

                            // Permitir que el formulario se envíe
                            $("#ModalEditar form").unbind('submit').submit();
                        }
                    },
                    error: function() {
                        // Maneja errores de la solicitud AJAX
                        alert("Error en la solicitud AJAX.");
                    }
                });
            });
            $('#ModalRegistrar').on('hidden.bs.modal', function() {
                // Vaciar o establecer en un estado predeterminado los campos de texto
                $('#Apellido-name, #Nombre-name, #Dni-name, #Telefono-name, #Fenac-alumno, #Colegio-alumno, #Ciudad-name, #Direccion-name, #Nombrea-alumno, #Celulara-alumno').val('');

                // Establecer la imagen del avatar y el input file en su estado predeterminado
                $('#img').attr('src', './src/assets/images/img_fond.jpg');
                $('#foto').val('');

                // Seleccionar el primer valor en los elementos select
                $('#Genero-name, #area-alumno, #universidad-alumno').prop('selectedIndex', 0);
                limpiarselect('#carrera-alumno');

                // Puedes agregar aquí cualquier código adicional para limpiar otros elementos del modal
            });
            $('#area-alumno').change(function() {
                // Obtener el valor del área seleccionada
                var id_ar = $(this).val();
                console.log(id_ar);
                // Cargar las carreras correspondientes al área seleccionada
                if (id_ar != null || id_ar != '') {
                    obtenerCarreras(id_ar);
                } else {
                    limpiarselect('#carrera-alumno');

                }
            });
            // Cargar opciones de área al cargar la página
            $.ajax({
                url: './Alumno/actions/get_areas.php',
                type: 'GET',
                dataType: 'json', // Indica que esperas datos en formato JSON
                success: function(data) {
                    console.log(data);

                    // Limpiar y llenar las opciones del primer select (area-alumno)
                    $('#area-alumno').empty();

                    // Iterar sobre las opciones recibidas y agregarlas al select
                    for (var i = 0; i < data.length; i++) {
                        var option = data[i];
                        // Agregar opción al select
                        $('#area-alumno').append($('<option>', {
                            value: option.value,
                            text: option.label
                        }));
                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                    // Puedes agregar aquí código adicional para manejar el error, como mostrar un mensaje al usuario.
                }

            });


            $('#Area-alumnoU').change(function() {
                // Obtener el valor del área seleccionada
                var id_ar = $(this).val();
                console.log(id_ar);
                // Cargar las carreras correspondientes al área seleccionada
                if (id_ar != null || id_ar != '') {
                    obtenerCarrerasU(id_ar, null);

                } else {
                    limpiarselect('#Carrera-alumnoU');

                }
            });
            // Cargar opciones de área al cargar la página
            $.ajax({
                url: './Alumno/actions/get_areas.php',
                type: 'GET',
                dataType: 'json', // Indica que esperas datos en formato JSON
                success: function(data) {
                    console.log(data);

                    // Limpiar y llenar las opciones del primer select (area-alumno)
                    $('#Area-alumnoU').empty();

                    // Iterar sobre las opciones recibidas y agregarlas al select
                    for (var i = 0; i < data.length; i++) {
                        var option = data[i];
                        // Agregar opción al select
                        $('#Area-alumnoU').append($('<option>', {
                            value: option.value,
                            text: option.label
                        }));
                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                    // Puedes agregar aquí código adicional para manejar el error, como mostrar un mensaje al usuario.
                }
            });



        });
    </script>


    <script src="./src/assets/js/imagenes/imagenes2.js"></script>
    <script src="./src/assets/js/imagenes/imagenes.js"></script>

    <style type="text/css">
        #foto {
            display: none;
        }

        #foto2 {
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