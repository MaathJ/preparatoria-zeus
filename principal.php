<?php 
include_once("auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <div>
            <label for="nombre__turno">Nombre Turno</label>
            <input type="text" placeholder="Ingresa el nombre del turno ...">
        </div>
        <div>
            <label for="nombre__turno">Hora Entrada</label>
            <input type="time">
        </div>
        <div>
            <label for="nombre__turno">Hora Salida</label>
            <input type="time">
        </div>
        <div>
            <label for="tolerancian__min">Tolerancia</label>
            <input type="number">
        </div>
        <div>
            <select name="estados" id="estados_select">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

    </form>
</body>
</html>