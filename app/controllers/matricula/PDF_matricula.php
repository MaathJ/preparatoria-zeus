<?php 
include_once('../../../config/conexion.php');
include_once('../../../src/fpdf/fpdf.php');

$id = $_GET['cod'];

$sql_pdf = "SELECT * FROM matricula ma

            INNER JOIN alumno al ON ma.id_al = al.id_al
            INNER JOIN carrera ca ON al.id_ca = ca.id_ca
            INNER JOIN area ar ON ca.id_ar = ar.id_ar
            
            INNER JOIN ciclo ci on ma.id_ci = ci.id_ci
            INNER JOIN periodo pe ON ci.id_pe = pe.id_pe
            
            WHERE id_ma = $id";

$f_pdf=mysqli_query($cn, $sql_pdf);
$r=mysqli_fetch_assoc($f_pdf);

//DATOS
    $ciclo = "";//strtoupper( $r['nombre_pe'] );
    $entero = "VOLANTES";//strtoupper( $r[''] );
    $area = "";//strtoupper( $r['nombre_ar'] );
    /* Cadena grande */
    $escuela = mb_convert_encoding(ucwords(strtolower( $r['nombre_ca'] )), 'ISO-8859-1', 'UTF-8');
    $letras = strlen($escuela);
    /* ----------------- */
    $uni = "";//strtoupper( $r['uni_al'] );
    $celular = $r['celular_al'];
    $dni = $r['dni_al'];
    $nombre = ucwords(strtolower(mb_convert_encoding($r['apellido_al'].", ".$r['nombre_al'], 'ISO-8859-1', 'UTF-8')));
    /* Formato nacimiento */
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha = strtotime($r['fnac_al']);
    $naci = date('d', $fecha)." de ".$meses[date('n', $fecha)-1]." de ".date('Y', $fecha);
    /* ----------------- */
    $ciudad = mb_convert_encoding(ucwords(strtolower($r['ciudadp_al'])), 'ISO-8859-1', 'UTF-8');
    $colegio = mb_convert_encoding(ucwords(strtolower($r['colegio_al'])), 'ISO-8859-1', 'UTF-8');
    $apod = mb_convert_encoding(ucwords(strtolower($r['apoderado_al'])), 'ISO-8859-1', 'UTF-8');
    $cel_apod = $r['celapod_al'];

    /* Formato nacimiento */
    $ruta = '../../../src/assets/images/alumno/'.$dni.'.jpg';

    if(!file_exists($ruta)){
        $ruta = '../../../src/assets/images/alumno/desconocido.jpg';
    }


//-------------- PDF --------------
$pdf = new FPDF('P','mm','A4');
$pdf->addPage();

//FONDO DE MATRICULA
$pdf->Image('../../../src/assets/images/matricula/FICHA_DE_MATRICULA.jpg', 0, 0, 210, 297);

//INFORMACIÓN
    //CICLO
        $pdf->Ln(35);
        $pdf->SetFont('Arial', 'B', 19);
        switch($ciclo){
            case "VERANO": $pdf->Cell(8.4, 0, '',0, 0, 'L');
                            $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                            $pdf->Ln(30.8);
                            break;
            case "SEMI ANUAL": $pdf->Cell(51.8, 0, '',0, 0, 'L');
                                $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                                $pdf->Ln(30.8);
                                break;
            case "RM-RV": $pdf->Cell(101.1, 0, '',0, 0, 'L');
                            $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                            $pdf->Ln(30.8);
                            break;
            case "REPASO BRUTAL": $pdf->Ln(9.1);
                                $pdf->Cell(8.2, 0, '',0, 0, 'L');
                                $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                                $pdf->Ln(21.7);
                                break;
            default: $pdf->Ln(30.8);;
                    break;
        }

    //COMO SE ENTERO
        $pdf->SetFont('Arial', 'B', 19);
        switch($entero){
            case "REDES SOCIALES": $pdf->Cell(8, 0, '',0, 0, 'L');
                                    $pdf->Cell(10, 12.5, '',0, 0, 'L');
                                    $pdf->Ln(36.6);
                                    break;
            case "RECOMENDACION": $pdf->Cell(51.8, 0, '',0, 0, 'L');
                                    $pdf->Cell(10, 12.5, '',0, 0, 'L');
                                    $pdf->Ln(36.6);
                                    break;
            case "EX ALUMNO(A)": $pdf->Cell(101.1, 0, '',0, 0, 'L');
                                    $pdf->Cell(10, 12.5, '',0, 0, 'L');
                                    $pdf->Ln(36.6);
                                    break;
            case "VOLANTES": $pdf->Ln(10.3);
                                $pdf->Cell(7.8, 0, '',0, 0, 'L');
                                $pdf->Cell(10, 12.5, '',0, 0, 'L');
                                $pdf->Ln(26.3);
                                break;
        }
    //DATOS ALUMNO
        //AREA
            switch($area){
                case "INGENIERíA": $pdf->Cell(26.5, 0, '',0, 0, 'L');
                                    $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                                    break;
                case "BIOMéDICA": $pdf->Cell(88.8, 0, '',0, 0, 'L');
                                    $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                                    break;
                case "SOCIALES": $pdf->Cell(139, 0, '',0, 0, 'L');
                                    $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                                    break;
            }
        //ESCUELA
            $pdf->Ln(15);
        
            $pdf->Cell(30, 0, '',0, 0, 'L');
            if($letras <= 37){
                $pdf->SetFont('Times', 'B', 15);
            }else if($letras <= 50){
                $pdf->SetFont('Times', 'B', 12);  
            }else if($letras <= 63){
                $pdf->SetFont('Times', 'B', 10.5);  
            }else{
                $pdf->SetFont('Times', 'B', 7.5);  
            }
            $pdf->Cell(10, 12.5, $escuela,0, 0, 'L');

        //UNIVERSIDAD
            $pdf->Ln(13.2);
            $pdf->SetFont('Arial', 'B', 19);
            switch($uni){
                case "UNAP": $pdf->Cell(26.5, 0, '',0, 0, 'L');
                            $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                            break;
                case "UNSA": $pdf->Cell(63.8, 0, '',0, 0, 'L');
                            $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                            break;
                case "UNAJ": $pdf->Cell(101.5, 0, '',0, 0, 'L');
                            $pdf->Cell(10, 12.5, 'X',0, 0, 'L');
                            break;
                default: $pdf->Cell(138.7, 0, '',0, 0, 'L');
                        $pdf->Cell(10, 12.5, 'X',0, 0, 'L'); 
                        break;
            }

        //CELULAR
            $pdf->Ln(15);
            $pdf->SetFont('Times', 'B', 15);
            $pdf->Cell(30, 0, '',0, 0, 'L');
            $pdf->Cell(10, 12.5, $celular,0, 0, 'L');

        //DATOS PERSONALES
            $pdf->Image($ruta, 155, 45, 36, 40);

            $pdf->Ln(11.3);
            $pdf->SetFont('Times', 'B', 15);
            $pdf->Cell(82, 0, '',0, 0, 'L');
            $pdf->Cell(10, 12.5, $dni,0, 0, 'L');

            $pdf->Ln(6);
            $pdf->Cell(82, 0, '',0, 0, 'L');
            $pdf->Cell(10, 12.5, $nombre,0, 0, 'L');

            $pdf->Ln(6);
            $pdf->Cell(82, 0, '',0, 0, 'L');
            $pdf->Cell(10, 12.5, $naci,0, 0, 'L');

            $pdf->Ln(6);
            $pdf->Cell(82, 0, '',0, 0, 'L');
            $pdf->Cell(10, 12.5, $ciudad,0, 0, 'L');

            $pdf->Ln(6);
            $pdf->Cell(82, 0, '',0, 0, 'L');
            $pdf->Cell(10, 12.5, $colegio,0, 0, 'L');

    //DATOS APODERADO
        $pdf->Ln(17.5);
        $pdf->SetFont('Times', 'B', 15);
        $pdf->Cell(72, 0, '',0, 0, 'L');
        $pdf->Cell(10, 12.5, $apod,0, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(72, 0, '',0, 0, 'L');
        $pdf->Cell(10, 12.5, $cel_apod,0, 0, 'L');

    //DECLARACION
        $pdf->Ln(15);
        $pdf->SetFont('Times', 'B', 15);
        $pdf->Cell(16, 0, '',0, 0, 'L');
        $pdf->Cell(10, 12.5, $nombre,0, 0, 'L');

$pdf->Output();
?>