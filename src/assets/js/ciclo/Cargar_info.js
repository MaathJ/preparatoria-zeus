    // FUNCION PARA PODER CONDICIONAR EL INPUT DATE DE INICIO Y CULMINACION 
    document.addEventListener('DOMContentLoaded', function() {
        var fechaInicioInput = document.getElementById('fechaInicio');
        var fechaCulminacionInput = document.getElementById('fechaCulminacion');

        fechaInicioInput.addEventListener('input', function() {
            fechaCulminacionInput.min = fechaInicioInput.value;
            // Restablecer el valor de Fecha Culminacion si es menor a la nueva fecha mínima
            if (fechaCulminacionInput.value < fechaInicioInput.value) {
                fechaCulminacionInput.value = fechaInicioInput.value;
            }
        });
    });


    function cargar_info(dato) {
        document.getElementById('u_id').value = dato.id;
        document.getElementById('u_nombre').value = dato.nombre;
        document.getElementById('u_fechaCulminacion').value = dato.fechaculminacion;
        document.getElementById('u_fechainicio').value = dato.fechainicio;
        document.getElementById('u_periodo').value = dato.periodo;
        document.getElementById('u_precio').value = dato.precio;
        document.getElementById('u_id').value = dato.id;
        document.getElementById('u_estado').value = dato.estado;

        console.log(dato.turno);
        
        var turnosIds = dato.turno.split(', ');

        // Obtén todos los checkboxes de turnos
        var checkboxes = document.getElementsByName('checkturnoEditar[]');

        // Recorre los checkboxes y marca aquellos cuyos IDs estén en el array de turnosIds
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = turnosIds.includes(checkboxes[i].value);
        }



    }

  // Manejar el evento de clic en el botón de eliminar del modal
  $(document).on('click', '#confirmarEliminar', function () {
        // Obtener el ID del turno
        var id_ci = $(this).data('id');
        // Redirigir a la página de eliminación con el ID del turno
        window.location.href = 'app/controllers/ciclo/D_ciclo.php?cod=' + id_ci;
    });

        // Actualizar el ID del turno en el modal al abrirse
        $(document).on('show.bs.modal', '#modalConfirmarEliminar', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id_ci = button.data('id'); // Extraer la información de los atributos data-*
            var modal = $(this);
            // Actualizar el atributo data-id del botón de confirmarEliminar con el ID del turno
            modal.find('#confirmarEliminar').data('id', id_ci);
        });