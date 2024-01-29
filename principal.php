<?php
include_once("auth.php");
include_once("src/components/parte_superior.php");
include('./config/conexion.php');
$sql = "select * from periodo";
$f = mysqli_query($cn, $sql);
?>
<link rel="stylesheet" src="style.css" href="./bootstrap/bootstrap.css">
<link rel="stylesheet" src="style.css" href="./datatables/datatables.css">
<div class="container-page">
    <div>
        <p>Zeus<span> / Panel de Control</span></p>
        <h3>Panel de Control</h3>
    </div>
    
    </div>

</div>



<?php
include_once("src/components/parte_inferior.php")
?>
<script>


    let table = new DataTable('#table_periodo', {
        // "bInfo": false,
        responsive: true,
        language: {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": " _TOTAL_ registros",
            "infoEmpty": "No hay registros para mostrar",
            "infoFiltered": "(filtrado de _MAX_  registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Cargando...",
        },
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',
        buttons: [{
                extend: 'excelHtml5',
                autofilter: true,
                text: '<i class="fa-regular fa-file-excel"></i>',
                titleAttr: 'Exportar a Excel',
                // className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa-regular fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                exportOptions: {
                    columns: [0, 1]
                },
                customize: function(doc) {
                   
                    doc.content[1].table.body[0].forEach(function(h) {
                        h.fillColor = 'rgb(1, 1, 51)';
                    });
                    doc.content[1].table.widths = [
                        '50%',
                        '50%',
                    ]
                    doc.content[1].margin = [ 100, 0, 100, 0 ]
                },
            },
            {
                extend: 'print',
                text: '<i class="fa-solid fa-print"></i>',
                titleAttr: 'Imprimir',
                exportOptions: {
                    columns: [0, 1]
                },
                // className: 'btn btn-info'
            },
        ]

    });
</script>