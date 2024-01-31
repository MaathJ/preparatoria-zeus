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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" href="src/assets/images/logo-zeus.png">
    

</head>


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
                        <a style="cursor: pointer;" onclick="window.location.href='./principal.php'">
                            <i class="fa-solid fa-house icon"></i>
                            <span class="text nav-text">Panel de Control</span>
                        </a>
                    </li>

                    <li class="nav-link" id="button-estudiante">
                        <a style="cursor: pointer;">
                            <i class="fa-solid fa-users icon"></i>
                            <span class="text nav-text">Estudiantes</span>
                            <i class="fa-solid fa-arrow-turn-down icon row-section"></i>
                        </a>
                    </li>
                    <ul class="menu-links-options" id="links-estudiante">
                        <li class="links-options" onclick="window.location.href='./alumno.php'">Alumnos</li>
                        <li class="links-options" onclick="window.location.href='./area.php'">Area</li>
                        <li class="links-options" onclick="window.location.href='./carrera.php'">Carrera</li>
                        <li class="links-options" onclick="window.location.href='./asistencia.php'">Asistencia</li>
                    </ul>
                    

                    <li class="nav-link">
                        <a style="cursor: pointer;" onclick="window.location.href='./matricula.php'">
                            <i class="fa-solid fa-box-archive icon"></i>
                            <span class="text nav-text">Matriculas</span>
                        </a>
                    </li>

                    <li class="nav-link" id="button-ciclo">
                        <a style="cursor: pointer;">
                            <i class="fa-solid fa-book icon"></i>
                            <span class="text nav-text">Ciclos</span>
                            <i class="fa-solid fa-arrow-turn-down icon row-section"></i>
                        </a>
                    </li>
                    <ul class="menu-links-options" id="links-ciclo">
                        <li class="links-options" onclick="window.location.href='./ciclo.php'">Ciclo</li>
                        <li class="links-options" onclick="window.location.href='./periodo.php'">Periodo</li>
                        <li class="links-options" onclick="window.location.href='./turno.php'">Turno</li>
                    </ul>

                    <li class="nav-link">
                        <a style="cursor: pointer;" onclick="window.location.href='./descuento.php'">
                        <i class="fa-solid fa-bookmark icon"></i>
                            <span class="text nav-text">Descuentos</span>
                        </a>
                    </li>


                    <li class="nav-link">
                        <a style="cursor: pointer;" onclick="window.location.href='./forma_pago.php'">
                            <i class="fa-solid fa-money-bill icon"></i>
                            <span class="text nav-text">Formas de Pago</span>
                        </a>
                    </li>


                    <li class="nav-link" id="button-usuario">
                        <a style="cursor: pointer;">
                            <i class="fa-regular fa-user icon"></i>
                            <span class="text nav-text">Usuario</span>
                            <i class="fa-solid fa-arrow-turn-down icon row-section"></i>
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
                    <a href="./cerrar_sesion.php">
                        <i class="fa-solid fa-arrow-right-from-bracket icon"></i>
                        <span class="text nav-text">Cerrar Sesion </span>
                    </a>
                </li>
            </div>
        </div>
    </div>

                    <style>
                        
                        .arrow-toggle {
                            display: none;
                        }
                        /* Estudiante */
                        .sidebar.closeSideBar #button-estudiante .fa-arrow-turn-down {
                            display: none;
                        }
                        #links-estudiante {
                            display: none;
                        }
                        .sidebar.closeSideBar #links-estudiante {
                            display: none;
                        }


                        /* Ciclo */
                        .sidebar.closeSideBar #button-ciclo .fa-arrow-turn-down {
                            display: none;
                        }
                        #links-ciclo {
                            display: none;
                        }
                        .sidebar.closeSideBar #links-ciclo{
                            display: none;
                        }


                        /* Usuario */
                        .sidebar.closeSideBar #button-usuario .fa-arrow-turn-down {
                            display: none;
                        }
                        #links-usuario {
                            display: none;
                        }
                        .sidebar.closeSideBar #links-usuario{
                            display: none;
                        }

                    </style>

                    <script>

                        $(document).ready(function() {
                            // Función para activar el scroll de la barra lateral
                            function activarScroll() {
                            $(".menu-bar").css("overflow-y", "auto");
                            $(".menu-bar").css("max-height", $(window).height() - $(".header").outerHeight());
                            }

                            // Verificar y activar el scroll cuando el documento esté listo
                            activarScroll();

                            // Volver a verificar y activar el scroll si la ventana cambia de tamaño
                            $(window).resize(function() {
                            activarScroll();
                            });
                        });

                        //ESTUDIANTE
                        $(document).ready(function() {
                            $("#button-estudiante").on("click", function() {
                            $("#links-estudiante").slideToggle();
                            $(".fa-arrow-turn-down", this).toggleClass("arrow-toggle");
                            });
                        });                    
                        
                        $(document).ready(function() {
                            var sublistaVisible = false;
                            var sidebarContraida = $(".sidebar").hasClass("closeSideBar");

                            $("#button-estudiante").on("click", function() {
                            // Verificar si la barra lateral está contraída
                            sidebarContraida = $(".sidebar").hasClass("closeSideBar");

                            if (sidebarContraida) {
                                // Si la barra lateral está contraída, expandirla y mostrar la sublista
                                $(".sidebar").removeClass("closeSideBar");
                                $("#links-estudiante").slideDown();
                                $(".fa-arrow-turn-down", this).addClass("arrow-toggle");
                                sublistaVisible = true;
                            } else {
                                // Si la barra lateral está desplegada, ocultar o mostrar la sublista después de un clic
                                if (sublistaVisible) {
                                $("#links-estudiante").slideUp();
                                $(".fa-arrow-turn-down", this).removeClass("arrow-toggle");
                                } else {
                                $("#links-estudiante").slideDown();
                                $(".fa-arrow-turn-down", this).addClass("arrow-toggle");
                                }
                                sublistaVisible = !sublistaVisible;
                            }
                            });

                            // Ocultar la sublista cuando se contrae la barra lateral
                            $(".toggle").on("click", function() {
                            $("#links-estudiante").slideUp();
                            $(".fa-arrow-turn-down").removeClass("arrow-toggle");
                            sublistaVisible = false;
                            });
                        });

                        //CICLO
                        $(document).ready(function() {
                            $("#button-ciclo").on("click", function() {
                            $("#links-ciclo").slideToggle();
                            $(".fa-arrow-turn-down", this).toggleClass("arrow-toggle");
                            });
                        });

                        $(document).ready(function() {
                            var sublistaVisible = false;
                            var sidebarContraida = $(".sidebar").hasClass("closeSideBar");

                            $("#button-ciclo").on("click", function() {
                            // Verificar si la barra lateral está contraída
                            sidebarContraida = $(".sidebar").hasClass("closeSideBar");

                            if (sidebarContraida) {
                                // Si la barra lateral está contraída, expandirla y mostrar la sublista
                                $(".sidebar").removeClass("closeSideBar");
                                $("#links-ciclo").slideDown();
                                $(".fa-arrow-turn-down", this).addClass("arrow-toggle");
                                sublistaVisible = true;
                            } else {
                                // Si la barra lateral está desplegada, ocultar o mostrar la sublista después de un clic
                                if (sublistaVisible) {
                                $("#links-ciclo").slideUp();
                                $(".fa-arrow-turn-down", this).removeClass("arrow-toggle");
                                } else {
                                $("#links-ciclo").slideDown();
                                $(".fa-arrow-turn-down", this).addClass("arrow-toggle");
                                }
                                sublistaVisible = !sublistaVisible;
                            }
                            });

                            // Ocultar la sublista cuando se contrae la barra lateral
                            $(".toggle").on("click", function() {
                            $("#links-ciclo").slideUp();
                            $(".fa-arrow-turn-down").removeClass("arrow-toggle");
                            sublistaVisible = false;
                            });
                        });

                        //USUARIO

                        $(document).ready(function() {
                            $("#button-usuario").on("click", function() {
                            $("#links-usuario").slideToggle();
                            $(".fa-arrow-turn-down", this).toggleClass("arrow-toggle");
                            });
                        });

                        $(document).ready(function() {
                            var sublistaVisible = false;
                            var sidebarContraida = $(".sidebar").hasClass("closeSideBar");

                            $("#button-usuario").on("click", function() {
                            // Verificar si la barra lateral está contraída
                            sidebarContraida = $(".sidebar").hasClass("closeSideBar");

                            if (sidebarContraida) {
                                // Si la barra lateral está contraída, expandirla y mostrar la sublista
                                $(".sidebar").removeClass("closeSideBar");
                                $("#links-usuario").slideDown();
                                $(".fa-arrow-turn-down", this).addClass("arrow-toggle");
                                sublistaVisible = true;
                            } else {
                                // Si la barra lateral está desplegada, ocultar o mostrar la sublista después de un clic
                                if (sublistaVisible) {
                                $("#links-usuario").slideUp();
                                $(".fa-arrow-turn-down", this).removeClass("arrow-toggle");
                                } else {
                                $("#links-usuario").slideDown();
                                $(".fa-arrow-turn-down", this).addClass("arrow-toggle");
                                }
                                sublistaVisible = !sublistaVisible;
                            }
                            });

                            // Ocultar la sublista cuando se contrae la barra lateral
                            $(".toggle").on("click", function() {
                            $("#links-usuario").slideUp();
                            $(".fa-arrow-turn-down").removeClass("arrow-toggle");
                            sublistaVisible = false;
                            });
                        });
                    </script>

    <section class="home">
        <script src="src/assets/js/menulinks/links.js"></script>