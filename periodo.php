<?php
include_once("auth.php");
include_once("src/components/parte_superior.php");
include('./config/conexion.php');
$sql = "select * from periodo";
$f = mysqli_query($cn, $sql);
include('modales_periodo.php');
?>
<div class="container-page">
    <div>
        <p>Zeus<span> / Periodo</span></p>
        <h3>Periodo</h3>
    </div>
    <button class="periodo btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModalPeriodo" data-bs-whatever="@mdo" style="cursor: pointer;">Registrar</button>
    <div class="container-table" style="background-color: #fff; overflow:hidden">
        <div class="col-md-12" style="box-sizing: border-box;">
            <table class="table table-striped table_id" id="table_periodo" style="width:100%; box-sizing: border-box; overflow:hidden">
                <thead align="center" class="" style="color: #fff; background-color:#010133;">
                    <tr>
                        <th class="text-center">Periodo</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    while ($r = mysqli_fetch_assoc($f)) {
                    ?>
                        <?php
                        deleteModalPeriodo($r['id_pe']);
                        ?>
                        <tr>
                            <td align="center"><?php echo $r['nombre_pe'] ?></td>
                            <td align="center"><?php
                                                $estado = $r['estado_pe'];
                                                $button = '<button class="' . ($estado === "ACTIVO" ? 'active-button' : 'inactive-button') . '">' . $estado . '</button>';
                                                echo $button;
                                                ?>
                            </td>
                            <td>
                                <center>
                                    <a class="btn btn-sm btn-primary btn-circle" data-bs-toggle="modal" data-bs-target="#editarModalPeriodo" data-bs-whatever="@mdo" target="_parent" onclick="cargarInfoEdit({
                                                        'id': '<?php echo $r['id_pe'] ?? ''; ?>',
                                                        'nombre': '<?php echo $r['nombre_pe'] ?? ''; ?>',
                                                        'estado': '<?php echo $r['estado_pe'] ?? ''; ?>'
                                                    });">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger btn-circle " target="_parent" data-bs-toggle="modal" data-bs-target="#DeleteModalPeriodo<?php echo $r['id_pe'] ?>" data-bs-whatever="@mdo">
                                        <i class=" fas fa-trash"> </i>
                                    </a>
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
    <?php

    if (isset($_SESSION['success_message'])) {
        echo
        '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Éxito!",
                text: "' . $_SESSION['success_message'] . '",
                icon: "success"
            });
        }, 200);
    </script>';
        unset($_SESSION['success_message']);
    }

    if (isset($_SESSION['deleted_cycle'])) {
        echo
        '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Éxito!",
                text: "' . $_SESSION['deleted_cycle'] . '",
                icon: "success"
            });
        }, 500);
    </script>';
        unset($_SESSION['deleted_cycle']);
    }


    if (isset($_SESSION['error_cycle'])) {
        echo
        '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Error!",
                text: "' . $_SESSION['error_cycle'] . '",
                icon: "error"
            });
        }, 500);
        </script>';
        unset($_SESSION['error_cycle']);
    }

    if (isset($_SESSION['alert_message'])) {
        $alertMessage = $_SESSION['alert_message'];
        echo '<script>
        setTimeout(() => {
            Swal.fire({
                title: "¡Cuidado!",
                text: "' . $alertMessage . '",
                icon: "warning"
            });
        }, 500);
        </script>';
        unset($_SESSION['alert_message']);
    }

    ?>
</div>



<?php
include_once("src/components/parte_inferior.php")
?>
<script>
    const cargarInfoEdit = (data) => {
        document.getElementById('id_periodo').value = data.id;
        document.getElementById('edit_nombre_periodo').value = data.nombre;
        document.getElementById('estado').value = data.estado;
        console.log(data)
    }
</script>

<script src="src/assets/js/datatableIntegration.js"></script>

<script>
    initializeDataTable('#table_periodo');
</script>