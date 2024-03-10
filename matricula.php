<?php
include_once('auth.php');
include_once('./src/components/parte_superior.php');
?>
<?php
include('./config/conexion.php');

$sqlma = "SELECT 
SUM(CASE WHEN bo.estadodeu_bo = 'DEUDA' AND bo.estadodur_bo = 'ACTIVO' THEN bo.deuda_bo ELSE 0 END) AS total_deudas,
SUM(CASE WHEN bo.estadodur_bo = 'ACTIVO' THEN bo.mes_bo ELSE 0 END) AS total_meses,
ma.*, al.*, ci.*, us.*, de.*, pe.*
FROM 
matricula ma
INNER JOIN  
alumno al ON ma.id_al = al.id_al
INNER JOIN 
ciclo ci ON ma.id_ci = ci.id_ci
INNER JOIN 
periodo pe ON ci.id_pe = pe.id_pe
INNER JOIN 
usuario us ON ma.id_us = us.id_us
INNER JOIN  
descuento de ON ma.id_de = de.id_de
LEFT JOIN 
boleta bo ON ma.id_ma = bo.id_ma AND bo.estadodur_bo = 'ACTIVO'
GROUP BY 
ma.id_ma;

/* WHERE  ma.estado_ma ='ACTIVO' */ ";
?>
<!-- Asegúrate de incluir jQuery y jQuery UI -->

<link rel="stylesheet" href="./src/assets/css/matricula/matricula.css">

<link rel="icon" href="src/assets/images/logo-zeus.png">



<div class="container-page">
    <div>
        <p>Zeus<span> / Matricula</span></p>
        <h3>Matricula</h3>
    </div>

    <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalMatriculaRegistro" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>

    <br>
    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-responsive-sm" id="table_matricula" style="width:100%; box-sizing: border-box; overflow:hidden">
                <thead align="center" class="" style="color: #fff; background-color:#010133; height:52px; max-height:100%;">
                    <tr>
                        <!-- <th class="text-center">ID</th> -->
                        <th class="text-center">Nombres</th>
                        <th class="text-center">Apellidos</th>
                        <th class="text-center">Ciclo</th>
                        <th class="text-center">Mensualidad</th>
                        <th class="text-center">Meses</th>
                        <th class="text-center">Boletas</th>
                        <th class="text-center">Dias Restantes</th>
                        <th class="text-center">Deuda</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Operario</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fmat = mysqli_query($cn, $sqlma);
                    while ($rma = mysqli_fetch_assoc($fmat)) {
                        $id = $rma['id_ma'];
                        $inicio = $rma['fini_ci'];
                        $final = $rma['ffin_ci'];
                    ?>
                        <tr>
                            <td>
                                <?php echo $rma['nombre_al'] ?>
                            </td>
                            <td>
                                <?php echo $rma['apellido_al'] ?>
                            </td>
                            <td align="center">
                                <?php echo $rma['nombre_pe'] . ' ' . $rma['nombre_ci'] ?>
                            </td>
                            <td align="center">
                                <?php echo $rma['mensualidad_ma'] ?>
                            </td>
                            <td align="center">
                                <?php echo $rma['total_meses'] ?>
                            </td>
                            <td align="center">

                                <a class="btn btn-sm btn-success" href="boleta.php?id=<?php echo $rma['id_ma']; ?>"><i class="fa-solid fa-file-invoice"></i></a>

                            </td>

                            <td align="center">
                                <?php echo $rma['mensualidad_ma'] ?>
                            </td>
                            <td align="center">
                                <?php echo $rma['total_deudas'] ?>
                            </td>

                            <td>
                                <?php $estado = $rma['estado_ma'];
                                $button = '<button class= "' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button';
                                echo $button;
                                ?>
                                |
                            </td>
                            <td>
                                <span style="font-weight: bold; color:#010133">
                                    <?php echo $rma['nombre_us'] ?>
                                </span>
                                <?php echo $rma['freg_ma'] ?>
                            </td>

                            <td>


                                <center>
                                    <?php
                                    $texto = ""; // Asignar un valor por defecto a $texto

                                    // Realizar la consulta SQL para obtener la última boleta y su estado
                                    $sql_fecha = "SELECT estadodeu_bo, ffin_bo FROM boleta WHERE id_ma = $id ORDER BY ffin_bo DESC LIMIT 1";
                                    $f_fecha = mysqli_query($cn, $sql_fecha);

                                    // Obtener los datos de la última boleta si existen
                                    if ($r_fecha = mysqli_fetch_assoc($f_fecha)) {
                                        $inicio = $r_fecha['ffin_bo']; // Fecha de finalización de la última boleta
                                        $texto = $r_fecha['estadodeu_bo']; // Estado de la última boleta
                                    }

                                    // Verificar si el estado de la última boleta no es "DEUDA"
                                    if ($texto != "DEUDA") {
                                        // Si no es "DEUDA", mostrar el botón
                                    ?>
                                        <!-- Botón de registro -->
                                        <button class="turno btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#Registrar" data-bs-whatever="@mdo" style="cursor: pointer;" onclick="cargar_registro({
                                            'mensualidad': '<?php echo $rma['mensualidad_ma']; ?>',
                                            'volver':'<?php echo $id; ?>',
                                            'fini':'<?php echo $inicio; ?>',
                                            'ffin':'<?php echo $final; ?>'
                                        })">
                                            <!-- Ícono y texto del botón -->
                                            <span style="font-weight: 800;"> + </span>
                                            <i class="fa-solid fa-file-invoice"></i>
                                        </button>
                                    <?php
                                        // Cierre del bloque PHP después de mostrar el botón
                                    }
                                    ?>

                                    <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#ModalMatriculaEditar" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info_Editar({
                                                        'id_maU': '<?php echo $rma['id_ma'] ?? ''; ?>',
                                                        'monto_maU': '<?php echo $rma['monto_ma'] ?? ''; ?>',
                                                        'mensualidad_maU': '<?php echo $rma['mensualidad_ma'] ?? ''; ?>',
                                                        'matricula_maU': '<?php echo $rma['monto_ma'] ?? ''; ?>',
                                                        'estado_maU': '<?php echo $rma['estado_ma'] ?? ''; ?>',
                                                        'observacion_maU': '<?php echo $rma['observacion_ma'] ?? ''; ?>',
                                                        'id_ciU': '<?php echo $rma['id_ci'] ?? ''; ?>',
                                                        'id_usU': '<?php echo $rma['id_us'] ?? ''; ?>',
                                                        'id_deU': '<?php echo $rma['id_de'] ?? ''; ?>'
                                                    });">
                                        <i class="fas fa-edit"> </i></a>
                                    <a class="btn btn-sm btn-danger btn-circle " data-bs-toggle="modal" data-bs-target="#DeleteModalMatricula" data-bs-whatever="@mdo" target="_parent" onclick="cargar_info_Eliminar({
                                                'id_maD': '<?php echo $rma['id_ma'] ?? ''; ?>'
                                                });">
                                        <i class="fas fa-trash"> </i></a>

                                    <a class="btn btn-sm btn-warning btn-circle " data-bs-toggle="modal" data-bs-target="#PDFMatricula" data-bs-whatever="@mdo" target="_parent" onclick="cargar_pdf(<?php echo $rma['id_ma'] ?? ''; ?>)">
                                        <i class="fas fa-print"> </i></a>
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

    <!-- Para traer el modal boleta  -->
    <?php
    include_once('app/controllers/boleta/Modal_boleta.php');

    ?>




    <!-- MODAL PARA REGISTRAR REGISTRAR  -->
    <div class="modal fade" id="ModalMatriculaRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">REGISTRO MATRICULA:</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="./app/controllers/matricula/R_matricula.php" method="post">

                    <div class="modal-body row g-3">
                        <!-- Columna izquierda -->
                        <div class="col-md-12">
                            <h3 class="title"> Datos del Alumno</h3>
                            <hr>
                        </div>
                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="alumno" class="col-form-label" style="color: black;">Buscar:</label>
                                <div style="position: relative;">
                                    <input type="number" name="r_idal" id="r_idal" hidden>
                                    <input type="text" name="r_" placeholder="Buscar por nombre o DNI" class="form-control" id="buscadorAl">
                                    <ul id="listaAlumnos" style="position: absolute; top: 100%; left: 0; z-index: 1000;"></ul>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="nombre" class="col-form-label" style="color: black;">Nombre y apellidos:</label>
                                <input type="text" placeholder="Buscar por nombre o DNI" class="form-control" id="r_nombre" readonly required>
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="area" class="col-form-label" style="color: black;">Area:</label>
                                <input type="text" placeholder=" " class="form-control" id="r_area" readonly required>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="carrera" class="col-form-label" style="color: black;">Carrera:</label>
                                <input type="text" placeholder=" " class="form-control" id="r_carrera" readonly required>
                            </div>
                        </div>
                        <!-- Columna izquierda -->
                        <div class="col-md-12">
                            <h3 class="title"> Datos del Ciclo</h3>
                            <hr>
                        </div>


                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="ciclo" class="col-form-label" style="color: black;">Ciclo:</label>
                                <div style="position: relative;">

                                    <select name="r_lstciclo" id="select-ciclo" class="form-control">
                                        <option value="" disabled selected>Selecciona un Ciclo</option>
                                        <?php
                                        $sqlmatric = "SELECT ci.*  , pe.* FROM ciclo as ci INNER JOIN  periodo pe
                                                ON ci.id_pe = pe.id_pe 
                                                WHERE estado_ci='ACTIVO'";
                                        $fsql = mysqli_query($cn, $sqlmatric);

                                        while ($r = mysqli_fetch_assoc($fsql)) {
                                        ?>
                                            <option value="<?php echo $r['id_ci'] ?>"> <?php echo $r['nombre_pe'] . ' ' . $r['nombre_ci'] ?> </option>
                                        <?php

                                        }
                                        ?>


                                    </select>

                                </div>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="nombre" class="col-form-label" style="color: black;">Turno:</label>
                                <textarea class="form-control" id="r_turno" readonly required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h3 class="title"> Datos de la matricula</h3>
                            <hr>
                        </div>

                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="monto" class="col-form-label" style="color: black;">Costo De Matricula:</label>
                                <input type="number" name="r_montoM" placeholder="Ingrese el costo" class="form-control" id="r_montoM" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="r_descuento" class="col-form-label" style="color: black;">Descuento:</label>
                                <br>
                                <select class="form-control form-select-sm mb-3" name="r_lstdesc" id="select-desc">
                                    <option value="" disabled>Selecciona un descuento</option>
                                    <?php

                                    $sqldes = "SELECT * FROM descuento where estado_de = 'ACTIVO'";
                                    $fdes = mysqli_query($cn, $sqldes);

                                    while ($rdes = mysqli_fetch_assoc($fdes)) {


                                    ?>
                                        <option value="<?php echo $rdes['id_de'] ?> "> <?php echo $rdes['nombre_de'] . ' -  S/' . $rdes['monto_de'] ?> </option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="comentario" class="col-form-label" style="color: black;">Comentario:</label>

                                <textarea class="form-control" name="r_comentario" id="" cols="20" rows="10"></textarea>


                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="monto" class="col-form-label" style="color: black;">Monto Mensual:</label>
                                <input type="number" name="r_menCiclo" class="form-control" readonly id="r_menCiclo" required>


                            </div>

                            <div class="col-12 mb-3">
                                <label for="monto descuento" class="col-form-label" style="color: black;">Monto Descontado:</label>
                                <input type="number" name="r_montoD" class="form-control" readonly id="r_montdes">

                            </div>
                            <hr>

                            <div class="col-12 mb-3">
                                <label for="desciuento" class="col-form-label" style="color: black;">Monto Fijo:</label>
                                <input type="number" name="r_montoF" class="form-control" readonly id="r_montof" required>


                            </div>

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

    <!-- MODAL PARA EDITAR EL CICLO  -->
    <div class="modal fade" id="ModalMatriculaEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: -20px;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">EDITAR MATRICULA:</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="./app/controllers/matricula/U_matricula.php" method="post">

                    <input type="number" name="u_idma" class="form-control" id="id_maU" hidden>

                    <div class="modal-body row g-3">
                        <!-- Columna izquierda -->
                        <div class="col-md-12">
                            <h3 class="title"> Datos del Ciclo</h3>
                            <hr>
                        </div>


                        <div class="col-md-6">
                            <div class="col-12 mb-3">
                                <label for="ciclo" class="col-form-label" style="color: black;">Ciclo:</label>
                                <div style="position: relative;">

                                    <select name="u_lstciclo" id="select-cicloU">
                                        <option value="" disabled selected>Selecciona un Ciclo</option>
                                        <?php
                                        $sqlmatric = "SELECT ci.*  , pe.* FROM ciclo as ci INNER JOIN  periodo pe
                                                ON ci.id_pe = pe.id_pe 
                                                WHERE estado_ci='ACTIVO'";
                                        $fsql = mysqli_query($cn, $sqlmatric);

                                        while ($r = mysqli_fetch_assoc($fsql)) {
                                        ?>
                                            <option value="<?php echo $r['id_ci']; ?>"> <?php echo $r['nombre_pe'] . ' ' . $r['nombre_ci'] ?> </option>
                                        <?php

                                        }
                                        ?>


                                    </select>

                                </div>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="nombre" class="col-form-label" style="color: black;">Turno:</label>
                                <textarea class="form-control" id="r_turnoU" readonly required></textarea>
                            </div>
                        </div>
                        <!-- <div class="col-md-12">

                        <div class="col-6 mb-3">
                            <label for="nombre" class="col-form-label" style="color: black;">Precio:</label>
                            <input class="form-control" id="r_precio" readonly required>
                        </div>
                    </div> -->

                        <div class="col-md-12">
                            <h3 class="title"> Datos de la matricula</h3>
                            <hr>
                        </div>

                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="monto" class="col-form-label" style="color: black;">Costo De Matricula:</label>
                                <input type="number" name="u_montoM" placeholder="Ingrese el costo" class="form-control" id="montoMU">
                            </div>

                            <div class="col-12 mb-3">
                                <label for="r_descuento" class="col-form-label" style="color: black;">Descuento:</label>
                                <br>
                                <select class="form-select form-select-sm mb-3" name="u_lstdesc" id="select-descU">
                                    <option value="" disabled>Selecciona un descuento</option>
                                    <?php

                                    $sqldes = "SELECT * FROM descuento where estado_de = 'ACTIVO'";
                                    $fdes = mysqli_query($cn, $sqldes);

                                    while ($rdes = mysqli_fetch_assoc($fdes)) {


                                    ?>
                                        <option value="<?php echo $rdes['id_de'] ?>"> <?php echo $rdes['nombre_de'] . ' -  S/' . $rdes['monto_de'] ?> </option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="comentario" class="col-form-label" style="color: black;">Comentario:</label>

                                <textarea class="form-control" name="u_comentario" id="comentarioU" cols="20" rows="10"></textarea>


                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="col-12 mb-3">
                                <label for="monto" class="col-form-label" style="color: black;">Monto Mensual:</label>
                                <input type="number" name="r_menCiclo" class="form-control" readonly id="r_menCicloU" required>


                            </div>

                            <div class="col-12 mb-3">
                                <label for="monto descuento" class="col-form-label" style="color: black;">Monto Descontado:</label>
                                <input type="number" name="r_montoD" class="form-control" readonly id="r_montdesU">

                            </div>
                            <hr>

                            <div class="col-12 mb-3">
                                <label for="desciuento" class="col-form-label" style="color: black;">Monto Fijo:</label>
                                <input type="number" name="u_montoF" class="form-control" readonly id="r_montofU" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="estado">Estado</label>

                                <select class="form-control" name="txt_estado_edit" id="U_lstestado" required>
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="FINALIZADO">FINALIZADO</option>
                                    <option value="ANULADO">ANULADO</option>

                                </select>


                            </div>



                        </div>



                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary" id="registrar">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL PARA ELIMINAR EL CICLO  -->
    <div class="modal fade  " id="DeleteModalMatricula" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">Registro Periodo Academico</h4>
                </div>
                <div class="modal-body text-center">
                    <form action="app/controllers/matricula/D_matricula.php" method="POST">
                        Estas seguro de que quieres eliminar esta Matricula?
                        <input hidden type="number" name="id_maD" id="id_maD">
                        <button class="btn btn-danger btn-circle text-center">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA PDF -->
    <div class="modal fade  " id="PDFMatricula" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #010133; color: #ffffff;">
                    <h4 class="modal-title" id="exampleModalLabel">MATRICULA DOCUMENTO</h4>
                </div>
                <div class="modal-body">
                    <iframe id='pdfIFrame' width='1100' height='600'></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Colocar antes de los Script  -->
    <?php
    include_once('src/components/parte_inferior.php');
    ?>
    <!-- Verificar Datos de Registrar Matrícula  -->
    <script src="src/assets/js/matricula/verificardatos.js"></script>
    <!-- PARA EL BUSCAR Alumno  -->
    <script src="src/assets/js/matricula/buscaralumno.js"></script>
    <!-- PARA EL CARGAR DATOS DE CICLO  XD-->
    <script src="src/assets/js/matricula/obtenerciclo.js"></script>

    <!-- PARA EL CARGAR DATOS DE DESCUENTO -->

    <script src="src/assets/js/matricula/obtenerdesc.js"></script>

    <!-- PARA EL CARGAR DATOS DE EDITAR MATRÍCULA-->

    <script src="src/assets/js/matricula/cargardatosEditar.js"></script>
    <!-- PARA EL CARGAR DATOS DE ELIMINAR MATRÍCULA-->

    <script src="src/assets/js/matricula/cargardatosEliminar.js"></script>


    <!-- <script src="src/assets/js/datatableIntegration.js"></script> -->

    <script>
        $(document).ready(function() {
            var table = $('#table_matricula').DataTable({
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
                            columns: [0, 1, 2, 3, 4, 6, 7, 8, 9]
                        }

                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf"></i>',
                        titleAttr: 'Exportar a PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 6, 7, 8, 9]
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
                            columns: [0, 1, 2, 3, 4, 6, 7, 8, 9]
                        },

                    },
                ]
            });

            new $.fn.dataTable.FixedHeader(table);
        });

        function cargar_pdf(cod) {
            document.getElementById('pdfIFrame').src = 'app/controllers/matricula/PDF_matricula.php?cod=' + cod;
        }
    </script>

    <?php


    ?>