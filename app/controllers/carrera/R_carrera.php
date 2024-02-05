<?php

session_start();

include('../../../config/conexion.php');

if (isset($_POST['txtcarrera']) && isset($_POST['lstarea'])) {

    $carrera = $_POST['txtcarrera'];
    $area = $_POST['lstarea'];

    $sql_select = "SELECT nombre_ca FROM carrera";
    $result = mysqli_query($cn, $sql_select);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['nombre_ca'] === $carrera) {
                $_SESSION['alert_message'] = 'La carrera ' . $row['nombre_ca'] . ' ya se encuentra registrada';
                header('location: ../../../carrera.php');
                exit();
            }
        }
    }

    // Utilizando consulta preparada para mejorar la seguridad
    $sql = "INSERT INTO carrera(nombre_ca, estado_ca, id_ar) VALUES (?, 'ACTIVO', ?)";
    $stmt = mysqli_prepare($cn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $carrera, $area);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = 'Carrera registrada exitosamente';
        } else {
            $_SESSION['alert_message'] = 'Error al registrar la carrera';
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['alert_message'] = 'Error al preparar la consulta';
    }

    header('location: ../../../carrera.php');
    exit();
}

?>