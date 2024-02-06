<?php 
include_once('./config/conexion.php');
?>
    <style>
        /* Estilos generales */
.inputuser:hover {
  background-color: aliceblue !important;
  color: #000000 !important;
  transition: 1s !important;    
}

.inputuser:focus {
  background-color: aliceblue !important;
  color: #000000 !important;
  transition: 1s !important;
}

.inputuser:focus::placeholder {
  color: #000000 !important;
}

.inputuser:hover::placeholder {
  color: #000000 !important;
}

/* Estilos del rayo y la chispa */
.logo__form img {
    position: relative;
    animation: fallDown 1s ease-in-out, spark 0.5s ease-in-out 1s; /* Agrega la animación al cargar la página y la chispa después de 1 segundo */
}

@keyframes fallDown {
    from {
        transform: translateY(-100vh); /* Inicia fuera de la pantalla (arriba) */
    }
    to {
        transform: translateY(0); /* Termina en la posición original */
    }
}



    </style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparatoria Zeus</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="./src/assets/css/login/login.css"/>
    <link rel="icon" href="src/assets/images/logo-zeus.png">
</head>
<body >
    <div class="body__login">
        <div class="form__container">
            <div class="logo__form">
                <img class="form__logo__zeus" src="./src/assets/images/logo-zeus.png" alt="Logo">
            </div>
            <form class="login__form" action="security.php" method="POST">
                <label for="user">
                    Usuario
                </label>
                <input class="inputuser" name="user" id="user" type="text" placeholder="Usuario">
                <label for="password">
                    Contraseña
                </label>
                <input class="inputuser" name="password" id="password" type="password" placeholder="*******">

                <input type="submit" value="Registrar">
            </form>
        </div>
    </div>
    <footer class="footer">
        Somos Zeus ! Somos Familia ! ⚡
    </footer>
    
</body>
</html>