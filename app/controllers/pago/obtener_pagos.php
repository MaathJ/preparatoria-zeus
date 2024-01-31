<?php
include('../../../config/conexion.php'); 

$id_bo = $_GET['id_bo'];

$sql_deuda = "SELECT deuda_bo AS deuda
                FROM boleta
                WHERE id_bo = $id_bo";
$f_deuda = mysqli_query($cn, $sql_deuda);
$r_deuda = mysqli_fetch_assoc($f_deuda);

$deuda = $r_deuda['deuda'];


$sql_pag = "SELECT * FROM pago pa 
            INNER JOIN boleta bo ON bo.id_bo = pa.id_bo 
            INNER JOIN forma_pago fp ON pa.id_fp = fp.id_fp
            INNER JOIN matricula ma ON ma.id_ma = bo.id_ma
            WHERE bo.id_bo = '$id_bo' 
            ORDER BY freg_pa DESC"; 

$resultado = mysqli_query($cn, $sql_pag);
$temporal = mysqli_query($cn, $sql_pag);

$htmlTabla = '<table class="table table-striped" id="table_pagos">';
$htmlTabla .= '<thead align="center" style="color: #fff; background-color:#010133;">
                <tr>
                    <th>Fecha de pago</th>
                    <th>Monto</th>
                    <th>Forma de pago</th>
                    <th>Opciones</th>
                </tr>
              </thead>';
$htmlTabla .= '<tbody>';

if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $htmlTabla .= '<tr align="center">';
        $htmlTabla .= '<td>' . $fila['freg_pa'] . '</td>';
        $htmlTabla .= '<td>' . $fila['monto_pa'] . '</td>';
        $htmlTabla .= '<td><img src="src/assets/images/forma_pago/' . $fila['id_fp'] . '.jpg" onerror="this.src=\'src/assets/images/forma_pago/desconocido.jpg\'" height="30" width="30">' . $fila['nombre_fp'] . '</td>';
        $htmlTabla .= '<td> <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#Eliminar_pago"
        onclick="cargar_eliminar_pago({';

        $htmlTabla .="'id_pa' : '" . $fila['id_pa'] . "',";
        $htmlTabla .="'id_bo' : '" . $id_bo . "',";
        $htmlTabla .="'volver' : '" . $fila['id_ma'] . "',";
        
        $htmlTabla .='})" data-bs-dismiss="modal" >
        <i class="fas fa-trash"> </i> </a></td>';
        $htmlTabla .= '</tr>';
    }
} else {
    $htmlTabla .= '<tr><td colspan="4">No se encontraron pagos</td></tr>';
}

$htmlTabla .= '<tr>
                    <td align="right"> DEUDA: </td>
                    <td align="center">'. $deuda . '</td>
                    <td></td>
                    <td></td>
                <tr>';
$htmlTabla .= '</tbody>';
$htmlTabla .= '</table>';

echo $htmlTabla;
?>