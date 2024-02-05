<?php 
session_start();
include_once('../../../config/conexion.php');

// REGISTRO DATOS
$nomb = $_POST['txt_nomb'];

$nomb = strtoupper($nomb);

$sql_select = "SELECT nombre_fp FROM forma_pago";
$result = mysqli_query($cn, $sql_select);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['nombre_fp'] === $nomb) {
            $_SESSION['alert_message'] = 'La forma de pago ' . $row['nombre_fp'] . ' ya se encuentra registrada';
            header('location: ../../../forma_pago.php');
            exit();
        }
    }
}

$sql = "INSERT INTO forma_pago(nombre_fp, estado_fp)
    VALUES (?, 'ACTIVO')";
$stmt = mysqli_prepare($cn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $nomb);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = 'Forma de pago registrada exitosamente';
    } else {
        $_SESSION['alert_message'] = 'Error al registrar la forma de pago';
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['alert_message'] = 'Error al preparar la consulta';
}

$id = mysqli_insert_id($cn);

// REGISTRO FOTO
try {
    $archivo = $_FILES['img_foto']["tmp_name"]; 
    $nombres = $_FILES['img_foto']["name"];

    if ($archivo != null) {
        list($n, $e) = explode(".", $nombres);
        if ($e == "png" || $e == "jpg" || $e == "jpeg") {
            move_uploaded_file($archivo, "../../../src/assets/images/forma_pago/" . $id . ".jpg");
        }
    }
} catch (\Throwable $th) {}

mysqli_close($cn);
header('location: ../../../forma_pago.php');
exit();
?>
