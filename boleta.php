<?php 
include_once('auth.php');
include_once('config/conexion.php');
include_once('app/controllers/boleta/Modal_boleta.php');
include_once('app/controllers/pago/Modal_pago.php');
include_once('src/components/parte_superior.php');
?>
<link rel="stylesheet" href="src/assets/css/boleta/forma_pago.css">

<div class="container-page">
    <?php
        if(isset($_GET['id'])){
            $id = $_GET['id'];
 
            $sql="SELECT ma.*, ci.* 
            FROM matricula ma
            INNER JOIN ciclo ci ON ma.id_ci = ci.id_ci
            WHERE ma.id_ma = $id";
            $f=mysqli_query($cn, $sql);
            if($r = mysqli_fetch_assoc($f)){  
                $mensualidad = $r['mensualidad_ma']; 
                $inicio = $r['fini_ci'];
                $final = $r['ffin_ci'];
                $texto = "";
                
                $sql_fecha= "SELECT estadodeu_bo, ffin_bo FROM boleta WHERE id_ma = $id ORDER BY ffin_bo DESC LIMIT 1";
                $f_fecha = mysqli_query($cn, $sql_fecha);
                if($r_fecha = mysqli_fetch_assoc($f_fecha)){
                    $inicio = $r_fecha['ffin_bo'];
                    $texto = $r_fecha['estadodeu_bo'];
                }
    ?>
        <!-- CABECERA -->
        <div>
            <p>Zeus<span> / Boleta</span></p> 
            <h3>Matricula</h3>
            <h3>Otros datos del alumno</h3>
        </div>
        <?php 
            if($texto != "DEUDA"){
        ?>
            <button class="turno btn btn-primary" data-bs-toggle="modal" data-bs-target="#Registrar" data-bs-whatever="@mdo" style="cursor: pointer;" 
                onclick="cargar_registro({
                    'mensualidad': '<?php echo $mensualidad;?>',
                    'volver':'<?php echo $id;?>',
                    'fini':'<?php echo $inicio;?>',
                    'ffin':'<?php echo $final;?>'
                })">
                <i class="fa-solid fa-plus text-white"></i> Registrar
            </button>
        <?php } ?>
        <br>
        <!-- Tabla -->
        <div class="container-table" style="background-color: #fff;">
            <div class="col-md-12">
                <table class="table table-striped"  id="table_boleta">
                    <thead align="center" class=""  style="color: #fff; background-color:#010133;">
                        <tr>
                            <th>N° Boleta</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha culminación</th>
                            <th>Meses pagados</th>
                            <th>Monto Total</th>
                            <th>Deuda</th>
                            <th>Estado de la deuda</th>
                            <th>Estado de la boleta</th>
                            <th>Pagos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sqlB="SELECT * FROM boleta WHERE id_ma = $id ORDER BY ffin_bo DESC";
                            $fB=mysqli_query($cn, $sqlB);
                            while($rB=mysqli_fetch_assoc($fB)){
                        ?>
                            <tr>
                                <td>
                                    <?php echo $rB['nroboleta_bo']; ?>
                                </td>
                                <td>
                                    <?php echo $rB['fini_bo']; ?>
                                </td>
                                <td>
                                    <?php echo $rB['ffin_bo']; ?>
                                </td>
                                <td>
                                    <?php echo $rB['mes_bo']; ?>
                                </td>
                                <td>
                                    <?php echo $rB['preciofijo_bo']; ?>
                                </td>
                                <td>
                                    <?php echo $rB['deuda_bo']; ?>
                                </td>
                                <td>
                                    <?php $estado = $rB['estadodeu_bo'];
                                        $button = '<button class="' . ($estado === "PAGADO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                        echo $button;
                                    ?>
                                </td>
                                <td>
                                    <?php $estado = $rB['estadodur_bo'];
                                        $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                        echo $button;
                                    ?>
                                </td>
                                <td>
                                        <a class="btn btn-sm btn-primary btn-circle ver-pagos-btn" 
                                            id="abrir_pago"
                                           data-bs-toggle="modal" 
                                           data-bs-target="#ModalPago" 
                                           data-bs-whatever="@mdo" 
                                           data-id-bo="<?php echo $rB['id_bo']; ?>">VER PAGOS</a>
                                </td>
                                <td>
                                    <!-- BOTON EDITAR -->
                                    <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#Editar" data-bs-whatever="@mdo" onclick=" cargar_editar({
                                                'bol':' <?php echo $rB['nroboleta_bo'] ?? ''; ?> ',
                                                'id':' <?php echo $rB['id_bo'] ?? ''; ?> ',
                                                'volver':'<?php echo $id;?>',
                                            } )" >
                                        <i class="fas fa-edit"> </i></a>

                                    <!-- BOTON ELIMINAR -->
                                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#ModalEliminar" data-bs-whatever="@mdo" onclick=" cargar_eliminar({
                                                'id':' <?php echo $rB['id_bo'] ?? ''; ?> ',
                                                'volver':'<?php echo $id;?>',
                                            } )"><i class="fas fa-trash"> </i></a>

                                    <!-- BOTON AGREGAR PAGO -->
                                    <?php 
                                        if($rB['deuda_bo'] != 0){
                                    ?>
                                        <a  class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Registrar_pago" onclick="cargar_registro_pago({
                                            'id_bo': '<?php echo $rB['id_bo']; ?>',
                                            'deuda_bo': '<?php echo $rB['deuda_bo']; ?>',
                                            'volver_bo':'<?php echo $id;?>',
                                        });"> 
                                        <i class="fa-solid fa-sack-dollar"></i> </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
            }else{
                echo "<div class='container-table' style='background-color: #fff;'>
                        Esta página no existe
                        </div>";
            }
        }else{
            echo "<div class='container-table' style='background-color: #fff;'>
                Esta página no existe
            </div>";
        }
    ?>
</div>


<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
  Launch demo modal
</button> -->



<!-- SCRIPT PARA LISTA PAGOS-->
<script>
    $(document).ready(function () {
        $('.ver-pagos-btn').click(function () {
            var idBo = $(this).data('id-bo');
            $.ajax({
                type: 'GET',
                url: 'app/controllers/pago/obtener_pagos.php',
                data: {
                    id_bo: idBo
                },
                success: function (response) {
                    $('#cuerpo_pago').html(response);
                },
                error: function () {
                    console.error('Error al cargar los pagos.');
                }
            });
        });
    });
</script>
<!-- SCRIPT ESTADO -->
<script src="src/assets/js/estado.js"></script>

<?php
include_once('src/components/parte_inferior.php');
?>

<script src="src/assets/js/datatableIntegration.js"></script>

<script>initializeDataTable('#table_boleta');</script>

