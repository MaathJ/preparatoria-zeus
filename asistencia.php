<?php
include_once('auth.php');
include_once('config/conexion.php');
include_once('src/components/parte_superior.php');
?>
<link rel="stylesheet" href="src/assets/css/asistencia/asistencia.css">

<div class="container-page">

    <div>
        <p>Zeus<span> / Asistencia</span></p>
        <h3>Asistencia</h3>
    </div>

    <div class="container-asitencia" style="background-color: #fff;">
        <div class="asistencia-input-info">
            <div class="asis-img">
                <img src="src/assets/images/logo-zeus.png" alt="">
            </div>
            <div class="asis-input">
                <input class="form-control" type="text" placeholder="Escanear codigo de barras">
            </div>
            <div class="asis-button-ver">
                <button class="btn btn-primary">Ver Registros</button>
            </div>
        </div>
    </div>
    <div class="container-card-asistencia" style="background-color: #fff;">
        <div class="card-principal-info">
            <div class="card-asistencia-info">
                <h1>La Cruz Salvador,Elder Stefano</h1>
                <span>INGENIERIA</span>
            </div>
            <div class="card-asistencia-info-image">
                <img src="src/assets/images/alumno/232323.jpg" alt="">
            </div>
        </div>
        <div class="card-second-info">
            <span>21 AÑOS</span>
        </div>
        <div class="card-asistencia-footer">
            <div class="asis-footer-info">
                <span>CICLO: </span> VERANO 2024  III
            </div>
            <div class="asis-footer-info">
                <span>DEUDA: </span> S/110.0
            </div>
            <div class="asis-footer-info">
                <span>TURNO: </span> MAÑANA
            </div>
        </div>
    </div>
</div>

<?php
include_once('src/components/parte_inferior.php');
?>