<?php
include_once("auth.php");
include_once("src/components/parte_superior.php");
include('./config/conexion.php');

if ($_SESSION["usuario"]) {
    $nombreUsuario = $_SESSION["n_usuario"];
}

?>


<link rel="stylesheet" src="style.css" href="./bootstrap/bootstrap.css">
<link rel="stylesheet" src="style.css" href="./datatables/datatables.css">
<link rel="stylesheet" src="style.css" href="src/assets/css/dashboard/dashboard.css">
<link rel="icon" href="src/assets/images/logo-zeus.png">
<div class="container-page">
    <div>
        <p>Zeus<span> / Panel de Control</span></p>
        <h3>Panel de Control</h3>
    </div>
    <form action="backup.php" method="post">
    <button class="btn btn-primary" style="cursor: pointer;" name="backup_btn" value="Generar Backup">Generar BackUp</button>

                <center> <h1 style="font-size: 50px; padding:20px;">BIENVENIDO <?php echo $nombreUsuario;?></h1> </center>
    
                <div class="card-earningsasis" style="margin-top:15px; width:100%;">
                      <div class="card-earnings-title">
                        <span><i class="fa-solid fa-door-open"></i></span>
                        <p style="font-weight: 500; font-size: 30px;">Asistencia Total del día</p>
                      </div>
                      <h2 class="card-earnings-text" style="font-size: 40px;">
                        20
                      </h2>
                </div>


                <div class="content-left-tables">
                    <!-- LOS 20 ALUMNOS QUE NO TIENEN FALTAS -->
                    <div class="table">
                      <h3>Matrículas del día</h3>
                      <div class="content-table-one">
                        <!-- while -->
                          <div class="table-card">
                            <div class="table-card-info">
                              <div class="card-info">
                                <img src="src/assets/images/logo-zeus.png" width="30px" height="30px">
                              </div>
                              <div>
                                PERSONA
                              </div>
                            </div>
                            <div class="table-card-days">
                              ADMIN
                            </div>
                            <div class="table-card-days">
                              FECHA Y HORA
                            </div>
                          </div>
                        
                      </div>
                    </div>
                    <div class="table">
                      <h3>Matriculas a Vencer</h3>
                      <div class="content-table-one">
                            <!-- CONSULTA -->
                          <div class="table-card">
                            <div class="table-card-info">
                              <div class="card-info">
                                <img src="src/assets/images/logo-zeus.png" alt="img-dni">
                              </div>
                              <div>ABC</div>
                            </div>
                            <div class="table-card-days">
                              25 días
                            </div>
                          </div>
                        


    </form>
    </div>

</div>














<style>
    
</style>


<?php
include_once("src/components/parte_inferior.php")
?>
<script>
    let table = new DataTable('#table_periodo', {
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
                    doc.content[1].margin = [100, 0, 100, 0]
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
</script>