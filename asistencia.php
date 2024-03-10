<?php
include_once('auth.php');
include_once('config/conexion.php');
include_once('src/components/parte_superior.php');

?>

<link rel="stylesheet" href="src/assets/css/asistencia/asistencia.css">
<link rel="icon" href="src/assets/images/logo-zeus.png">


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
                <input class="form-control" id="buscador" type="text" placeholder="Escanear codigo de barras">
            </div>
            <div class="asis-button-ver">
                <a class="btn btn-primary" href="registro_asistencia.php" style="text-decoration: none;">Ver Registros</a>
            </div>
        </div>
    </div>
    <div class="container-card-asistencia matri-content" style="background-color: #fff;">

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#buscador').on('keyup', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                search();
            }
        });

    function search() {
        var dni = $('#buscador').val();

        // Verificar que la longitud del dni sea suficiente
        if (dni.length >= 8) { // Cambia este valor si el dni tiene una longitud diferente
                $.ajax({
                    url: './app/controllers/asistencia/controlasistencia.php',
                    type: 'POST',
                    data: {
                        dni: dni
                    },
                    dataType: 'json',  // Indica que esperas datos en formato JSON
                    success: function(data) {
                        // escenario---Numero de evento,
                        console.log(data); 
                        switch (data[0].escenario){
                        case 1:{
                            Swal.fire({
                            title: data[0].mensaje,
                            text: "Agregue al alumno o considere actualizar el DNI",
                            icon: "warning"
                        });};
                        break;
                        case 2:{
                            Swal.fire({
                            title: data[0].mensaje,
                            text: "Registre una matrícula o revise su horario",
                            icon: "warning"
                        });};
                        break;
                        case 3:{
                            Swal.fire({
                            title: data[0].mensaje,
                            text: "Genere su boleta",
                            icon: "warning"
                        });};
                        break;
                        case 4:{
                            Swal.fire({
                            title: "Asistencia exitosa",
                            text: "Se registró exitosamente",
                            icon: "success"
                        });
                    
                        $('.matri-content').html(data[0].info);
                        $('#buscador').val("");
                        clearTimeout(timeoutId);
                        var timeoutId = setTimeout(function () {
                            $('.matri-content').empty();
                        }, 15000);
                        

                        };
                        break;
                        case 5:{
                            Swal.fire({
                            title: data[0].mensaje,
                            text: "ya registro su asistencia",
                            icon: "warning"
                        });};
                        break;    
                        case 6:{
                            Swal.fire({
                            title: data[0].mensaje,
                            text: "Ningun turno existe a esta hora",
                            icon: "warning"
                        });};
                        break;  
        }
    },

    error: function(xhr, status, error) {
        console.error("Error en la solicitud AJAX:", status, error);
        // Puedes agregar aquí código adicional para manejar el error, como
    }
});

            }
        }
    });
</script>


<?php
include_once('src/components/parte_inferior.php');
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script  type="text/javascript">
</script>