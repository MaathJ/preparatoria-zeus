<?php  

include('../config/conexion.php');


$nombre = $_POST['txtnombre'];
$apellido = $_POST['txtapellido'];

// Verificar si la codificación es necesaria y corregir problemas de codificación UTF-8
if (!mb_check_encoding($nombre, 'UTF-8')) {
    $nombre = mb_convert_encoding($nombre, 'UTF-8', 'ISO-8859-1');
}

if (!mb_check_encoding($apellido, 'UTF-8')) {
    $apellido = mb_convert_encoding($apellido, 'UTF-8', 'ISO-8859-1');
}
$nombre = trim(mb_strtoupper($nombre, 'UTF-8'));
$apellido = trim(mb_strtoupper($apellido, 'UTF-8'));


$dni = $_POST['txtdni'];
$telefono = $_POST['txttelefono'];
$direccion = trim($_POST['txtdireccion']);
$genero = $_POST['lstgenero'];
$fnac= $_POST['txtfnac'];

$colegio = trim($_POST['txtcolegio']);

$archivo = $_FILES['foto']["tmp_name"]; 
$nombres=$_FILES["foto"]["name"];

$ciudad=trim($_POST['txtciudad']);

$direccion = trim($_POST['txtdireccion']);

$idarea=$_POST['lstarea'];

$idcarrera= $_POST['lstcarrera'];



// Llamar al procedimiento almacenado para obtener el nombre del área
$sql = "CALL ObtenerNombreArea(?)";
$stmt = $cn->prepare($sql);

// Bind de parámetros
$stmt->bind_param("i", $idarea);

// Ejecutar el procedimiento almacenado
$stmt->execute();

// Vincular el resultado a una variable
$stmt->bind_result($nombreArea);

// Obtener el resultado
$stmt->fetch();

// Cerrar la conexión y liberar recursos
$stmt->close();

// Hacer lo que necesitas con $nombreArea...

// Llamar al procedimiento almacenado para obtener el nombre de la carrera
$sql = "CALL ObtenerNombreCarrera(?)";
$stmt = $cn->prepare($sql);

// Bind de parámetros
$stmt->bind_param("i", $idcarrera);

// Ejecutar el procedimiento almacenado
$stmt->execute();

// Vincular el resultado a una variable
$stmt->bind_result($nombreCarrera);

// Obtener el resultado
$stmt->fetch();

// Cerrar la conexión y liberar recursos
$stmt->close();



$universidad= $_POST['lstuniversidad'];
$nombreap= $_POST['nombrea-alumno'];
$celularap= $_POST['celulara-alumno'];
if (!mb_check_encoding($nombreap, 'UTF-8')) {
    $nombreap = mb_convert_encoding($nombreap, 'UTF-8', 'ISO-8859-1');
}

if (!mb_check_encoding($celularap, 'UTF-8')) {
    $celularap= mb_convert_encoding($celularap, 'UTF-8', 'ISO-8859-1');
}
$nombreap = trim(mb_strtoupper($nombreap, 'UTF-8'));
$celularap = trim(mb_strtoupper($celularap, 'UTF-8'));

$ESTADO="ACTIVO";



	$sql = "CALL InsertarAlumno(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $cn->prepare($sql);

// Bind de parámetros
$stmt->bind_param("ssssssssssssssis", $nombre, $apellido, $dni, $telefono, $fnac, $ciudad, $colegio, $universidad, $nombreArea, $nombreCarrera,$ESTADO, $direccion, $nombreap, $nombrecelularap, $idcarrera,$genero);
echo $nombre.$apellido. $dni. $telefono. $fnac. $ciudad. $colegio. $universidad. $nombreArea. $nombreCarrera.$ESTADO.$direccion. $nombreap. $celularap. $idcarrera.$genero;
// Ejecutar el procedimiento almacenado
$stmt->execute();
// Cerrar la conexión y liberar recursos
$stmt->close();

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $archivo = $_FILES['foto']['tmp_name'];
    $nombres = $_FILES['foto']['name'];

    $lastDotPosition = strrpos($nombres, ".");
    if ($lastDotPosition !== false) {
        $n = substr($nombres, 0, $lastDotPosition);
        $e = substr($nombres, $lastDotPosition + 1);
    } else {
        // Si no hay punto en el nombre del archivo, manejar según tus necesidades
        // Puedes asignar un valor predeterminado a $n y $e, o mostrar un mensaje de error, etc.
        $n = $nombres;
        $e = '';
    }

    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $imageType = exif_imagetype($archivo);

    if (in_array($e, $allowedExtensions) && ($imageType == IMAGETYPE_JPEG || $imageType == IMAGETYPE_PNG)) {
        // Genera un nombre único para evitar conflictos
        $nombreArchivo = $dni . '.jpg';

        // Mueve el archivo a la ubicación deseada
        move_uploaded_file($archivo, "../src/assets/images/alumno/" . $nombreArchivo);
        header('location: ../alumno.php');
    } else {
        header('location: ../alumno.php');
    }
} else {
    $archivop = '../src/assets/images/alumno/predt.jpg';
    // Genera un nombre único para evitar conflictos
    $nombreArchivo = $dni . '.jpg';

        // Si no se ha seleccionado un archivo, asigna la foto predeterminada
        copy('../src/assets/images/alumno/predt.jpg', "../src/assets/images/alumno/" . $dni . '.jpg');

    header('location: ../alumno.php');
}


?>