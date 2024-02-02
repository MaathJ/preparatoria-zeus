<?php  

include('../../../config/conexion.php');

$volver=$_POST['txt_volver'];

$b =$_POST['txt_nboleta'];
$fi = $_POST['txt_fini'];
$ff = $_POST['txt_ffin'];
$m = $_POST['txt_mes'];
$p = $_POST['txt_precio'];
$d = $_POST['txt_deuda'];


$monto = $_POST['txt_monto'];
$f_pago = $_POST['opc_fp'];


$sql_boleta = "select id_bo from boleta where nroboleta_bo = $b";
$numero = mysqli_query($cn, $sql_boleta);

$bol = mysqli_num_rows($numero);


 
if($bol<= 0){
	if ($d == 0) {
		$estado_boleta = 'PAGADO';
	} else {
		$estado_boleta = 'DEUDA';
	}

	$fecha_actual= new DateTime( date('Y-m-d') );
	$fecha_final = new DateTime( $ff );
	$fecha_inicio= new DateTime( $fi );
	if($fecha_actual > $fecha_final){
		$estado_asi = 'INACTIVO';
	}else if($fecha_actual >= $fecha_inicio){
		$estado_asi = 'ACTIVO';
	}else{
		$estado_asi = 'EN ESPERA';
	}


	$sql = "insert into boleta values (0, '$b','$fi','$ff','$m','$p','$d', '$estado_asi', '$estado_boleta', $volver)"; 
		$f =  mysqli_query($cn, $sql);
		$id = mysqli_insert_id($cn);


	$sql_pago = "insert into pago (id_pa, monto_pa,	estado_pa, id_bo, id_fp) values (0, '$monto', 'ACTIVO','$id', '$f_pago')";
		mysqli_query($cn, $sql_pago);
		mysqli_close($cn);

	$ruta="location: ../../../boleta.php?id=".$volver;
	header($ruta);
}else{
	mysqli_close($cn);

	$ruta="location: ../../../boleta.php?id=".$volver.'&mensaje=1';
	header($ruta);
}

?>