function obtenerDCiclo(idCiclo) {
    console.log(idCiclo);
    $.ajax({
        url: './app/controllers/matricula/actions/cargardatosciclo.php',
        type: 'POST',
        data: {
            id_Ciclo: idCiclo
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);

            // Limpiar txtarea e input text
            document.getElementById("r_turno").value = '';
            /* document.getElementById("r_precio").value = ''; */

            // Llenar el textarea con los turnos
            var txtarea = document.getElementById("r_turno");
            for (var i = 0; i < data.turno_ci.length; i++) {
                txtarea.value += data.turno_ci[i] + '\n';
            }

            $('#r_turno').addClass('inputAcep');
            /* $('#r_precio').addClass('inputAcep'); */
            $('#r_menCiclo').addClass('inputAcep');
            
            // Establecer el precio en el input
            /* document.getElementById("r_precio").value = data.precio_ci; */
            document.getElementById("r_menCiclo").value = data.precio_ci;

            //Actualizar Monto Fijo
            recargartotales();
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
            // Puedes agregar aquí código adicional para manejar el error
        }
    });

}
function recargartotales() {
    let menC = parseFloat($('#r_menCiclo').val()) || 0;
    let montdes = parseFloat($('#r_montdes').val()) || 0;
    console.log(montdes);
    $('#r_montof').val(menC - montdes);
    $('#r_montof').addClass('inputAcep');

}

$(document).ready(function() {

    $('#select-ciclo').change(function() {
        // Obtener el valor del ciclo seleccionado
        var id_ci = $(this).val();
        console.log(id_ci);
        // Cargar los turnos correspondientes al ciclo seleccionada
        if (id_ci != null || id_ci != '') {
            obtenerDCiclo(id_ci);
        } else {
            //limpiar txtarea e input text
            document.getElementById("r_turno").value = '';
            document.getElementById("r_menCiclo").value = 0;
        }
    });

});