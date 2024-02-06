<?php
include_once('auth.php');
include_once('config/conexion.php');
include_once('src/components/parte_superior.php');

?>

<link rel="stylesheet" href="src/assets/css/asistencia/asistencia.css">
<link rel="icon" href="src/assets/images/logo-zeus.png">
<link rel="icon" href="src/assets/css/estado.css">


<style>

    .inputbuscar {
        width: 580px;
        height: 100px;
        border-radius: 50px;
        border: 2px solid rgb(1, 1, 51);
        font-size: 25px;
        padding-top: 35px; /* Ajusta el padding superior para centrar el texto verticalmente */
        padding-bottom: 35px; /* Ajusta el padding inferior para centrar el texto verticalmente */
        text-align: center; /* Centra el texto horizontalmente */

        box-shadow: 0px 0px 10px rgb(1, 1, 51) , inset 0px 0px 3px rgb(1, 235, 252),0px 0px 2px rgb(255, 255, 255);

    }

    .inputbuscar:focus{
        border: 1px solid ;
        color: #010133;
    

        box-shadow: 0px 0px 10px rgb(92, 68, 233)
    }

    .asis-button-verHora {
        background-color: #010133;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        font-family: Arial, sans-serif;
        color: #333;
        width: 200px;
    }

    #time {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin-bottom: 10px;
    }

    #date {
        font-size: 18px;
        color:  #C4CAFB;
    }


</style>
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
            <div class="asis-button-verHora" id="clock">
                <div id="time"></div>
                <div id="date"></div>
            </div>
            <div class="asis-input">
                <input class="form-control inputbuscar" id="buscador" type="text" placeholder="Escanear el  codigo de barras ">
            </div>
           

            <div class="asis-button-ver">
                <a class="btn btn-primary" href="registro_asistencia.php" style="text-decoration: none;">Ver Registros</a>
            </div>
        </div>
    </div>
    <div class="container-card-asistencia matri-content" style="background-color: #fff;">
    </div>
    <div class="container-asitencia" style="background-color: #fff;">
        <div class="asistencia-input-info" style="display: flex; flex-direction: column; ">
            
            <button class="btn btn-danger" style="text-decoration: none; border-radius: 50px;" id="cerrar_asi">CERRAR ASISTENCIA</button>
            <br>
            <p>(Cuando culmine la hora de tardanza puede cargar las faltas) </p> 
            <br>
            <p style="color: orange ;"> AVISO :Una vez cerrado la asistencia los que no asistieron se registraran como falta. </p> 
            
        </div>
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
            var dni = $('#buscador').val().trim();
            // Verificar que la longitud del dni sea suficiente
            if (dni.length >= 3) { // Cambia este valor si el dni tiene una longitud diferente
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
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#buscador').val("");
                        };
                            break;
                            case 2:{
                                Swal.fire({
                                title: data[0].mensaje,
                                text: "Registre una matrícula o revise su horario",
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#buscador').val("");
                        };
                            break;
                            case 3:{
                                Swal.fire({
                                title: data[0].mensaje,
                                text: "Genere su boleta",
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#buscador').val("");
                        };
                            break;
                            case 4:{
                                Swal.fire({
                                title: "Asistencia exitosa",
                                text: "Se registró exitosamente",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1000
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
                                text: "",
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $('#buscador').val("");
                        };
                            break;    
                            case 6:{
                                Swal.fire({
                                title: data[0].mensaje,
                                text: "Ningun turno existe a esta hora",
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#buscador').val("");
                        };
                            break;  
                            case 7:{
                                Swal.fire({
                                title: data[0].mensaje,
                                text: "Registre el cierre de asistencia",
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#buscador').val("");
                        };
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
    
<script>
    $(document).ready(function () {
        $('#cerrar_asi').on('click', function (event) {
            $.ajax({
                url: './app/controllers/asistencia/cerrarasistencia.php',
                type: 'POST',
                data: {
                    dni: 0,
                },
                dataType: 'json',  // Indica que esperas datos en formato JSON
                success: function(data) {
                    // escenario---Numero de evento,
                    console.log(data); 
                    switch (data[0].escenario){
                        case 1:{
                            Swal.fire({
                            title: data[0].mensaje,
                            text: data[0].texto,
                            icon: "warning"
                        });};
                        break;
                        case 2:{
                            Swal.fire({
                            title: data[0].mensaje,
                            text: data[0].texto,
                            icon: "success"
                        });};
                        break;
                    }
                },

                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                    // Puedes agregar aquí código adicional para manejar el error, como
                }
            });
        });  
    });
</script>


<?php
include_once('src/components/parte_inferior.php');
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">

</script>

    <script>
        function updateTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();
            var day = now.getDate();
            var month = now.getMonth() + 1; // Sumamos 1 ya que en JavaScript los meses van de 0 a 11
            var year = now.getFullYear();

            // Determinamos si es AM o PM
            var meridiem = hours >= 12 ? 'PM' : 'AM';
            // Convertimos la hora al formato de 12 horas
            hours = hours % 12;
            // Si es 0, entonces son las 12 AM
            hours = hours ? hours : 12;
            // Agregamos un 0 adelante si los minutos o los segundos son menores que 10
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Formateamos la hora y la fecha
            var timeString = hours + ':' + minutes + ':' + seconds + ' ' + meridiem;
            var dateString = day + '/' + month + '/' + year;

            // Actualizamos el contenido de los elementos con los nuevos valores
            document.getElementById('time').innerHTML = timeString;
            document.getElementById('date').innerHTML = dateString;
        }

        // Llamamos a updateTime() cada segundo para que el reloj se actualice
        setInterval(updateTime, 1000);

        // Llamamos a updateTime() al cargar la página para mostrar la hora y la fecha actuales
        updateTime();
    </script>

