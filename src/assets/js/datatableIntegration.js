
function initializeDataTable(tableId) {
    let table = new DataTable(tableId, {
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
        responsive: "true",
        dom: 'Bfrtilp',
        buttons: [{
                extend: 'excelHtml5',
                autofilter: true,
                text: '<i class="fa-regular fa-file-excel"></i>',
                titleAttr: 'Exportar a Excel',
                
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
                
            },
        ]

    });
}