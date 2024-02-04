<?php
session_start();
include('../../../config/conexion.php');
if (
    isset($_POST['txtturno']) &&
    isset($_POST['txthent']) &&
    isset($_POST['txthsal']) &&
    isset($_POST['txttolerancia'])
) {
    $turno = $_POST['txtturno'];
    $hent = $_POST['txthent'];
    $hsal = $_POST['txthsal'];
    $tolerancia = $_POST['txttolerancia'];
    $estado = "ACTIVO";

    $sql_select = "SELECT nombre_tu FROM turno";
    $result = mysqli_query($cn, $sql_select);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['nombre_tu'] === $turno) {
                $_SESSION['alert_message'] = ('El turno ' . $row['nombre_tu'] . ' ya se encuentra registrado');
                header('location: ../../../turno.php');
                exit();
            }
        }
    }
    $sql = "INSERT INTO turno (nombre_tu, hent_tu, hsal_tu, tolerancia_tu, estado_tu) VALUES ('$turno', '$hent', '$hsal', '$tolerancia', '$estado')";
    $f = mysqli_query($cn, $sql);

    if ($f) {
        $_SESSION['success_message'] = 'Turno registrado exitosamente';
    } else {
        throw new Exception('Error al registrar el turno');
    }


    header('location:../../../turno.php');
}
