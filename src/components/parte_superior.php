<?php
include_once('././config/conexion.php');

if ($_SESSION["usuario"]) {
    $nombreUsuario = $_SESSION["n_usuario"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparatoria Zeus</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boostrap 5  -->
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <script src="src/assets/js/boostrap/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" src="style.css" href="./datatables/datatables.css">
</head>

<body>
    <div class="sidebar closeSideBar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="src/assets/images/logo-zeus.png" alt="logo">
                </span>

                <div class="text header-text">
                    <span class="name">Preparatoria Zeus</span>
                </div>
            </div>

            <i class="fa-solid fa-chevron-right toggle"></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                            <i class="fa-solid fa-house icon"></i>
                            <span class="text nav-text">Panel de Control</span>
                        </a>
                    </li>

                    <li class="nav-link" id="button-estudiante">
                        <a style="cursor: pointer;">
                            <i class="fa-solid fa-users icon"></i>
                            <span class="text nav-text">Estudiantes</span>
                        </a>
                    </li>
                    <ul class="menu-links-options" id="links-estudiante">
                        <li class="links-options" onclick="window.location.href='./alumno.php'">Alumnos</li>
                        <li class="links-options" onclick="window.location.href='./area.php'">Area</li>
                        <li class="links-options" onclick="window.location.href='./carrera.php'">Carrera</li>
                    </ul>
                    <li class="nav-link">
                        <a href="#">
                            <i class="fa-solid fa-box-archive icon"></i>
                            <span class="text nav-text">Matriculas</span>
                        </a>
                    </li>

                    <li class="nav-link" id="button-ciclo">
                        <a style="cursor: pointer;">
                            <i class="fa-solid fa-book icon"></i>
                            <span class="text nav-text">Ciclos</span>
                        </a>
                    </li>
                    <ul class="menu-links-options" id="links-ciclo">
                        <li class="links-options" onclick="window.location.href='./ciclo.php'">Ciclo</li>
                        <li class="links-options" onclick="window.location.href='./periodo.php'">Periodo</li>
                        <li class="links-options" onclick="window.location.href='./turno.php'">Turno</li>
                    </ul>


                    <li class="nav-link">
                        <a href="#">
                            <i class="fa-solid fa-money-bill icon"></i>
                            <span class="text nav-text">Pagos</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class="fa-solid fa-file icon"></i>
                            <span class="text nav-text">Reportes</span>
                        </a>
                    </li>


                    <li class="nav-link" id="button-usuario">
                        <a style="cursor: pointer;">
                        <i class="fa-regular fa-user icon"></i>
                            <span class="text nav-text">Usuario</span>
                        </a>
                    </li>
                    <ul class="menu-links-options" id="links-usuario">
                        <li class="links-options" onclick="window.location.href='./roles.php'">Roles</li>
                        <li class="links-options" onclick="window.location.href='./usuario.php'">Usuario</li>

                    </ul>

                </ul>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="#">
                        <i class="fa-solid fa-user icon"></i>
                        <span class="text nav-text" style="text-transform: capitalize;">

                            <?php
                            echo $nombreUsuario;
                            ?>

                        </span>
                    </a>
                </li>
                <li class="">
                    <a href="#">
                        <i class="fa-solid fa-arrow-right-from-bracket icon"></i>
                        <span class="text nav-text">Cerrar Sesion</span>
                    </a>
                </li>
            </div>
        </div>
    </div>

    <section class="home">
    <script src="src/assets/js/menulinks/links.js"></script>