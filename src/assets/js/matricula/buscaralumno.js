
$(document).ready(function() {
    function manejarBusqueda() {
        var inputText = $('#buscadorAl').val().trim();

        if (inputText.length > 0) {
            $.ajax({
                url: 'app/controllers/matricula/actions/buscarAlumno.php',
                method: 'POST',
                data: {
                    busqueda: inputText
                },
                success: function(data) {
                    $('#listaAlumnos').html(data).show();
                }
            });
        } else {
            $('#listaAlumnos').empty().hide();
        }
    }

    // Asignar el evento input al campo de entrada
    $('#buscadorAl').on('input', function() {
        manejarBusqueda();
    });

    // Asignar el evento click al campo de entrada
    $('#buscadorAl').on('click', function() {
        manejarBusqueda();
    });

    // Manejar la selección de elementos de la lista
    $(document).on('click', '#listaAlumnos li', function() {
        var selectedText = $(this).text().trim(); // Obtener el texto seleccionado
        var dni = selectedText.match(/\(([^)]+)\)/)[1]; // Extraer el DNI del texto seleccionado

        // Realizar una nueva solicitud AJAX para obtener los detalles del alumno seleccionado
        $.ajax({
            url: 'app/controllers/matricula/actions/buscarAlumnoDetalles.php',
            method: 'POST',
            data: {
                dniSeleccionado: dni
            }, // Enviar el DNI seleccionado del alumno
            success: function(data) {
                // Analizar los datos JSON devueltos por el script PHP
                var alumnoDetalles = JSON.parse(data);
                console.log(data);
                // Actualizar los campos con los detalles del alumno
                $('#r_idal').val(alumnoDetalles.id_al);
                console.log($('#r_idal').val());
                $('#r_nombre').val(alumnoDetalles.nombre_al + ' ' + alumnoDetalles.apellido_al);
                $('#r_area').val(alumnoDetalles.nombre_ar);
                $('#r_carrera').val(alumnoDetalles.nombre_ca);

                $('#r_nombre').addClass('inputAcep')
                $('#r_area').addClass('inputAcep')
                $('#r_carrera').addClass('inputAcep')
                
                $('#buscadorAl').val('');
            }
        });

        $('#listaAlumnos').empty().hide(); // Vaciar la lista y ocultarla
    });

    // Manejar clics fuera del campo de búsqueda
    $(document).on('click', function(event) {
        var target = $(event.target);
        // Si el clic no se realizó en el campo de búsqueda ni en la lista de alumnos, oculta la lista.
        if (!target.is('#buscadorAl') && !target.closest('#listaAlumnos').length) {
            $('#listaAlumnos').empty().hide();
        }
    });
});