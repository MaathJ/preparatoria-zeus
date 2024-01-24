<?php
session_start();

include_once('../../../config/conexion.php');

$id = $_GET['id'];

$sql_select = "SELECT nombre_pe FROM periodo WHERE id_pe = '$id'";
$result = mysqli_query($cn, $sql_select);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $nombre_ciclo = $row['nombre_pe'];

    $sql_delete = "DELETE FROM periodo WHERE id_pe = '$id'";
    mysqli_query($cn, $sql_delete);

    $_SESSION['deleted_cycle'] = "Ciclo eliminado: '$nombre_ciclo' con ID: $id";
} else {
    $_SESSION['deleted_cycle'] = "No se pudo obtener la información del ciclo con ID: $id";
}

header('location: ../../../periodo.php');
?>
