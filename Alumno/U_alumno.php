<?php  


include('../config/conexion.php');
mb_internal_encoding('UTF-8');


$cn->set_charset("utf8");
// Obtener los datos del formulario
$id_al = $_POST['id_alumnoU'];
$nombre_al = $_POST['txtnombreU'];
$apellido_al = $_POST['txtapellidoU'];
$dni_al = $_POST['txtdniU'];
$celular_al = $_POST['txttelefonoU'];
$fnac_al = $_POST['txtfnacU'];
$ciudadp_al = $_POST['txtciudadU'];
$colegio_al = $_POST['txtcolegioU'];
$uni_al = $_POST['lstuniversidadU'];
$genero_al = $_POST['lstgeneroU'];
$area_al = $_POST['lstareaU'];
$carrera_al = $_POST['lstcarreraU'];
// Obtener el nombre del área
$sql = "CALL ObtenerNombreArea(?)";
$stmt = $cn->prepare($sql);
$stmt->bind_param("i", $area_al);  // Suponiendo que $area_al es el ID del área
$stmt->execute();
$stmt->bind_result($nombreArea);
$stmt->fetch();
$stmt->close();

// Obtener el nombre de la carrera
$sql = "CALL ObtenerNombreCarrera(?)";
$stmt = $cn->prepare($sql);
$stmt->bind_param("i", $carrera_al);  // Suponiendo que $carrera_al es el ID de la carrera
$stmt->execute();
$stmt->bind_result($nombreCarrera);
$stmt->fetch();
$stmt->close();

// Hacer lo que necesitas con $nombreArea y $nombreCarrera...

$estado_al = isset($_POST['checkestado']) ? $_POST['checkestado'] : 'INACTIVO';

$direccion_al = $_POST['txtdireccionU'];
$apoderado_al = $_POST['nombrea-alumnoU'];
$celapod_al = $_POST['celulara-alumnoU'];





// Llamar al procedimiento almacenado
$sqlea = "CALL editar_alumno(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $cn->prepare($sqlea);

// Bind de parámetros
$stmt->bind_param("issssssssssssssis", $id_al, $nombre_al, $apellido_al, $dni_al, $celular_al, $fnac_al, $ciudadp_al, $colegio_al, $uni_al, $nombreArea, $nombreCarrera, $estado_al, $direccion_al, $apoderado_al, $celapod_al, $carrera_al, $genero_al);

// Ejecutar el procedimiento almacenado
$stmt->execute();

// Cerrar la conexión y liberar recursos
$stmt->close();


if (isset($_FILES['foto2']) && $_FILES['foto2']['error'] == UPLOAD_ERR_OK) {
    $archivo = $_FILES['foto2']['tmp_name'];
    $nombres = $_FILES['foto2']['name'];

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


    $allowedExtensions = ['png', 'jpg', 'jpeg', 'JPG', 'JPEG'];
    $imageInfo = getimagesize($archivo);

    // Verificar que es una imagen y el tipo está permitido
    if ($imageInfo && in_array($e, $allowedExtensions) && ($imageInfo[2] == IMAGETYPE_JPEG || $imageInfo[2] == IMAGETYPE_PNG)) {
        // Genera un nombre único para evitar conflictos
        $nombreArchivo = $dni_al . '.' . 'jpg';

        // Mueve el archivo a la ubicación deseada
        move_uploaded_file($archivo, "../src/assets/images/alumno/" . $nombreArchivo);
        echo '<script type="text/javascript">
           window.location = "../alumno.php";
           setTimeout(function(){
               window.location.reload(); // Esto recargará la página después de un breve retraso (en milisegundos)
           }, 1000); // Ejemplo: recarga después de 1 segundo (ajusta según sea necesario)
      </script>';



    } else {
        echo '<script type="text/javascript">
           window.location = "../alumno.php";
           setTimeout(function(){
               window.location.reload(); // Esto recargará la página después de un breve retraso (en milisegundos)
           }, 1000); // Ejemplo: recarga después de 1 segundo (ajusta según sea necesario)
      </script>';


    }
} else {
    $archivop = '../src/assets/images/alumno/predt.jpg';
    // Genera un nombre único para evitar conflictos
    $nombreArchivo = $dni_al . '.jpg';

        // Si no se ha seleccionado un archivo, asigna la foto predeterminada
        copy('../src/assets/images/alumno/predt.jpg', "../src/assets/images/alumno/" . $dni_al . '.jpg');
        echo '<script type="text/javascript">
           window.location = "../alumno.php";
           setTimeout(function(){
               window.location.reload(); // Esto recargará la página después de un breve retraso (en milisegundos)
           }, 1000); // Ejemplo: recarga después de 1 segundo (ajusta según sea necesario)
      </script>';



    
}


?>