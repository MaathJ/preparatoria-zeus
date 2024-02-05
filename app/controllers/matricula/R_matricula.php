<?php
session_start();

include_once('../../../auth.php');
include_once('../../../config/conexion.php');

// Obtener los valores del formulario
$montoM = $_POST['r_montoM'];
$montoF = $_POST['r_montoF'];
$estado = 'ACTIVO';
$comentario = $_POST['r_comentario'];
$idal = $_POST['r_idal'];
$idci = $_POST['r_lstciclo'];
$idus = $_SESSION["usuario"];
$idde = $_POST['r_lstdesc'];

// Crear la consulta SQL
$sql = "INSERT INTO matricula (monto_ma, mensualidad_ma, estado_ma, observacion_ma, id_al, id_ci, id_us, id_de)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($cn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ddssiiii", $montoM, $montoF, $estado, $comentario, $idal, $idci, $idus, $idde);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = 'Matrícula registrada exitosamente';
    } else {
        $_SESSION['alert_message'] = 'Error al registrar la matrícula';
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['alert_message'] = 'Error al preparar la consulta';
}

header('location: ../../../matricula.php');
exit();
?>
