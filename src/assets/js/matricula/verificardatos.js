document.addEventListener("DOMContentLoaded", function() {
    var enviadoMatriculaReg = false;

$("#ModalMatriculaRegistro form").submit(function(event) {
    if (enviadoMatriculaReg) {
        return;
    }
    // Detén el envío del formulario
    event.preventDefault();
    let inputIdAl=document.getElementById('r_idal');
    let inputIdAlValue= inputIdAl.value;

    if (inputIdAlValue == '' || inputIdAlValue == null) {
        alert('Por favor, selecciona un alumno.');
        return;
    }

    let selectElementCiclo= document.getElementById('select-ciclo');
    let selectedValueCiclo= selectElementCiclo.value;
    // Verifica si se ha seleccionado una opción válida
    if (selectedValueCiclo == '' || selectedValueCiclo == null) {
        alert('Por favor, selecciona un ciclo.');
        return;
    }

    let selectElementDesc= document.getElementById('select-desc');
    let selectedValueDesc= selectElementDesc.value;

    // Verifica si se ha seleccionado una opción válida
    if (selectedValueDesc == '' || selectedValueDesc == null) {
        alert('Por favor, selecciona un descuento.');
        return;
    }
    // Marcar el formulario como enviado
    enviadoMatriculaReg = true;

    $("#ModalMatriculaRegistro form").unbind('submit').submit();
});
});
