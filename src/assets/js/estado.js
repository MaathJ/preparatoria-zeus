// Obtener una lista de elementos por su atributo data
var tdConLabel = document.querySelectorAll('td[data-estado]');
var tdConImagen = document.querySelectorAll('td[data-imagen]');

// Iterar sobre la lista y cambiar el color de cada td
tdConLabel.forEach(function(label) {
    var estado = label.getAttribute('data-estado');
    if(estado != "ACTIVO"){
        label.style.color = "#909497";
    }else{
        label.style.fontWeight = "bold";
    }
});

tdConImagen.forEach(function(td) {
    var estado = td.getAttribute('data-imagen');
    var imagen = td.querySelector('img'); // Obtener la imagen dentro del td

    if (estado !== "ACTIVO" && imagen) {
      imagen.style.opacity = "0.5";
    }
});