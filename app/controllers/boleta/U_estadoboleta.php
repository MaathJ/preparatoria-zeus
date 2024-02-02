<?php 
include('config/conexion.php');

$sql="SELECT * FROM boleta
    WHERE estadodur_bo != 'INACTIVO'";
$f=mysqli_query($cn,$sql);

$fecha_actual= new DateTime( date('Y-m-d') );

while($r=mysqli_fetch_assoc($f)){
    
	$fecha_final = new DateTime( $r['ffin_bo'] );
	$fecha_inicio= new DateTime( $r['fini_bo'] );

    $id=$r['id_bo'];
    $estado = $r['estadodur_bo'];

    $estado_dur="";
    $sql_boleta="";
    
    if($estado == "ACTIVO"){
        if($fecha_actual > $fecha_final){
            $estado_dur = 'INACTIVO';

            $sql_boleta="UPDATE boleta
                        SET estadodur_bo = '$estado_dur'
                        WHERE id_bo = $id";
            mysqli_query($cn, $sql_boleta);
        }
    }else if($estado == "EN ESPERA"){
        if($fecha_actual >= $fecha_inicio){
            $estado_dur = 'ACTIVO';

            $sql_boleta="UPDATE boleta
                        SET estadodur_bo = '$estado_dur'
                        WHERE id_bo = $id";
            mysqli_query($cn, $sql_boleta);
        }
    }
}
?>