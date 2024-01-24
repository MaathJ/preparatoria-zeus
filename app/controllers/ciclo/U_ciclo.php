<?php 

include('../../../config/conexion.php');

$codigo = $_POST['cod'];
$nombre = $_POST['u_nombre'];
$fechainicio = $_POST['u_fechainicio'];
$fechaCulminacion = $_POST['u_fechaculminacion'];
$periodo = $_POST['u_lstperiodo'];
$precio = $_POST['u_precio'];
$estado = $_POST['u_lstestado'];

$turnos = isset($_POST['checkturnoEditar']) ? $_POST['checkturnoEditar'] : [];


$sql ="UPDATE ciclo SET nombre_ci = '$nombre',
            fini_ci = '$fechainicio',
            ffin_ci = '$fechaCulminacion',
            precio_ci = $precio,
            estado_ci = '$estado',
            id_pe = $periodo
            WHERE id_ci = $codigo
         ";
$f=mysqli_query($cn,$sql);




if ($f) {

     $sqlDelD = "DELETE FROM detalle_ciclo_turno Where id_ci= $codigo ";
     $fD= mysqli_query($cn,$sqlDelD);
      
     if ($fD) {

        foreach ($turnos as $id_turno) {
            $sqldetalle = "INSERT INTO detalle_ciclo_turno (id_ci , id_tu, estado_ct) 
                           VALUES ($codigo, $id_turno, 'ACTIVO')";
            $fdetalle = mysqli_query($cn, $sqldetalle);
        }
        header("Location: ../../../ciclo.php");

       
     }
   
   
     header("Location: ../../../ciclo.php");



}else{


    header("Location: ../../../ciclo.php");
}




?>