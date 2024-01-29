function obtenerDesc(id_des) {
    console.log(id_des);
    $.ajax({
        url: './app/controllers/matricula/actions/cargardatosdescuento.php',
        type: 'POST',
        data: {
            id_des: id_des
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);

            // Limpiar txtarea e input text
            $('#r_montdes').val('');
            $('#r_montdes').addClass('inputAcep');

            // Establecer el precio en el input
            $('#r_montdes').val(data.precio_de);
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
    $('#select-desc').change(function() {
        // Obtener el valor del ciclo seleccionado
        var id_des = $(this).val();
        console.log(id_des);
        // Cargar los turnos correspondientes al ciclo seleccionada
        if (id_des) {
            obtenerDesc(id_des);
            
        } else {
            // Limpiar txtarea e input text
            $('#r_montdes').val('');
        }
    });
    $('#select-desc').val($('#select-desc option:first').val()).change();
});
