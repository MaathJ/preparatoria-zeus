<?php
include_once('./config/conexion.php');
session_start();  

$usuario = $_POST["user"];
$pass = $_POST["password"];

$stmt = mysqli_prepare($cn, "CALL VerificarCredenciales(?, ?)");

if (!$stmt) {
    die("Error al preparar la declaración: " . mysqli_error($cn));
}

mysqli_stmt_bind_param($stmt, 'ss', $usuario, $pass);
mysqli_stmt_execute($stmt);


mysqli_stmt_bind_result($stmt, $estado, $id_usuario);


$resultado = mysqli_stmt_fetch($stmt);


mysqli_stmt_close($stmt);
mysqli_close($cn);


if ($resultado && $estado == true) {
    $_SESSION["n_usuario"] = $usuario;
    $_SESSION["usuario"] = $id_usuario;
    $_SESSION["auth"] = 1;
    header("location: principal.php");
} else {
    $_SESSION["usuario"] = null;
    $_SESSION["auth"] = 0;
    header("location: index.php");
}
?>
