<?php 
include_once('./config/conexion.php');
?>
<style>
.inputuser:hover{
  background-color: aliceblue !important;
  color: #000000 !important;
  transition: 1s !important;    
  
}

.inputuser:focus{
  background-color: aliceblue !important;
  color: #000000 !important;
  transition: 1s !important;

}
/* Estilo para el color del placeholder en estado :focus */
.inputuser:focus::placeholder {
  color: #000000 !important;
}

/* Estilo para el color del placeholder en estado :hover */
.inputuser:hover::placeholder {
  color: #000000 !important;
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