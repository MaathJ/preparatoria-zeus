function cargar_info_Editar(dato) {
    //seleccionar el valor del select ciclo
    $('#select-cicloU').val(dato.id_ciU);
    //obtener los datos de ciclo
    obtenerDCicloU(dato.id_ciU);  
    //obtenemos en un input los valores id matricula,comentario matrìcula y monto matrìcula
    document.getElementById('id_maU').value = dato.id_maU;
    document.getElementById('comentarioU').value = dato.observacion_maU;
    document.getElementById('montoMU').value = dato.matricula_maU;
    //seleccionar el value descuento
    $('#select-descU').val(dato.id_deU).change();

        var estadoSelect = document.getElementById('U_lstestado');

    for (var i = 0; i < estadoSelect.options.length; i++) {
        if (estadoSelect.options[i].value == dato.estado_maU) {
            estadoSelect.options[i].selected = true;
            break;
        }
    }
/*     var cicloSelect = document.getElementById('select-cicloU');

    for (var i = 0; i < cicloSelect.options.length; i++) {
        if (cicloSelect.options[i].value == dato.id_ciU) {
            cicloSelect.options[i].selected = true;
            break;
        }
    } */

    /* var descSelect= document.getElementById('select-descU');

    for (var i = 0; i < descSelect.options.length; i++) {
        if (descSelect.options[i].value == dato.id_deU) {
            descSelect.options[i].selected = true;
            break;
        }
    } */


}

function obtenerDCicloU(idCiclo) {
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
            document.getElementById("r_turnoU").value = '';
            /* document.getElementById("r_precio").value = ''; */

            // Llenar el textarea con los turnos
            var txtarea = document.getElementById("r_turnoU");
            for (var i = 0; i < data.turno_ci.length; i++) {
                txtarea.value += data.turno_ci[i] + '\n';
            }

            $('#r_turnoU').addClass('inputAcep');
            /* $('#r_precio').addClass('inputAcep'); */
            $('#r_menCicloU').addClass('inputAcep');
            
            // Establecer el precio en el input
            /* document.getElementById("r_precio").value = data.precio_ci; */
            document.getElementById("r_menCicloU").value = data.precio_ci;

            //Actualizar Monto Fijo
            recargartotalesU();
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
            // Puedes agregar aquí código adicional para manejar el error
        }
    });

}
function recargartotalesU() {
    let menC = parseFloat($('#r_menCicloU').val()) || 0;
    let montdes = parseFloat($('#r_montdesU').val()) || 0;
    console.log(montdes);
    $('#r_montofU').val(menC - montdes);
    $('#r_montofU').addClass('inputAcep');

}

$(document).ready(function() {

    $('#select-cicloU').change(function() {
        // Obtener el valor del ciclo seleccionado
        var id_ci = $(this).val();
        console.log(id_ci);
        // Cargar los turnos correspondientes al ciclo seleccionada
        if (id_ci != null || id_ci != '') {
            obtenerDCicloU(id_ci);
        } else {
            //limpiar txtarea e input text
            document.getElementById("r_turnoU").value = '';
            document.getElementById("r_menCicloU").value = 0;
        }
    });

});

function obtenerDescU(id_des) {
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
            $('#r_montdesU').val('');
            $('#r_montdesU').addClass('inputAcep');

            // Establecer el precio en el input
            $('#r_montdesU').val(data.precio_de);
            //Actualizar Monto Fijo
            recargartotalesU();
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
            // Puedes agregar aquí código adicional para manejar el error
        }
    });
}
$(document).ready(function() {
    $('#select-descU').change(function() {
        // Obtener el valor del ciclo seleccionado
        var id_des = $(this).val();
        console.log(id_des);
        // Cargar los turnos correspondientes al ciclo seleccionada
        if (id_des) {
            obtenerDescU(id_des);
            
        } else {
            // Limpiar txtarea e input text
            $('#r_montdesU').val('');
        }
    });
    
});
