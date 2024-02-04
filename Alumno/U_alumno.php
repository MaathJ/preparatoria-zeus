<?php  


include('../config/conexion.php');
mb_internal_encoding('UTF-8');


$cn->set_charset("utf8");
// Obtener los datos del formulario
$id_al = $_POST['id_alumnoU'];
$nombre_al = $_POST['txtnombreU'];
$apellido_al = $_POST['txtapellidoU'];
if (!mb_check_encoding($nombre_al , 'UTF-8')) {
    $nombre_al = mb_convert_encoding($nombre_al , 'UTF-8', 'ISO-8859-1');
}

if (!mb_check_encoding($apellido_al, 'UTF-8')) {
    $apellido_al= mb_convert_encoding($apellido_al, 'UTF-8', 'ISO-8859-1');
}
$nombre_al = trim(mb_strtoupper($nombre_al, 'UTF-8'));
$apellido_al = trim(mb_strtoupper($apellido_al, 'UTF-8'));

$dni_al = $_POST['txtdniU'];
$celular_al = $_POST['txttelefonoU'];
$fnac_al = $_POST['txtfnacU'];
$ciudadp_al = trim($_POST['txtciudadU']);
$colegio_al = trim($_POST['txtcolegioU']);
$uni_al = $_POST['lstuniversidadU'];
$genero_al = $_POST['lstgeneroU'];
$area_al = $_POST['lstareaU'];
$carrera_al = $_POST['lstcarreraU'];

$sqldniantiguo="select dni_al from alumno where id_al=$id_al";
$fsqldni=mysqli_query($cn,$sqldniantiguo);
$csqldni=mysqli_fetch_assoc($fsqldni);
$dni_alant = $csqldni['dni_al'];
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

$direccion_al = trim($_POST['txtdireccionU']);

$apoderado_al = $_POST['nombrea-alumnoU'];
$celapod_al = $_POST['celulara-alumnoU'];
if (!mb_check_encoding($apoderado_al, 'UTF-8')) {
    $apoderado_al= mb_convert_encoding($apoderado_al, 'UTF-8', 'ISO-8859-1');
}

if (!mb_check_encoding($celapod_al, 'UTF-8')) {
    $celapod_al= mb_convert_encoding($celapod_al, 'UTF-8', 'ISO-8859-1');
}
$apoderado_al = trim(mb_strtoupper($apoderado_al, 'UTF-8'));
$celular_al = trim(mb_strtoupper($celular_al, 'UTF-8'));




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
        // Genera nombres únicos para evitar conflictos
        $nombreArchivoAntiguo = $dni_alant . '.' . 'jpg';
        $nombreArchivoNuevo = $dni_al . '.' . 'jpg';

        $rutaArchivoAntiguo = "../src/assets/images/alumno/" . $nombreArchivoAntiguo;
        $rutaArchivoNuevo = "../src/assets/images/alumno/" . $nombreArchivoNuevo;

        // Verificar si el archivo antiguo existe antes de intentar eliminarlo
        if (file_exists($rutaArchivoAntiguo)) {
            // Eliminar el archivo antiguo
            unlink($rutaArchivoAntiguo);

            // Crear uno nuevo con el nuevo DNI
            // Puedes hacer esto simplemente moviendo o copiando un archivo por defecto, o creándolo de alguna otra manera
            move_uploaded_file($archivo, "../src/assets/images/alumno/" . $nombreArchivoNuevo);
        }
        header('location: ../alumno.php');

    } else {
        header('location: ../alumno.php');
    }
} else {
    // Solo renombrar el archivo existente al nuevo DNI
    $nombreArchivoAntiguo = $dni_alant . '.' . 'jpg';
    $nombreArchivoNuevo = $dni_al . '.' . 'jpg';

    $rutaArchivoAntiguo = "../src/assets/images/alumno/" . $nombreArchivoAntiguo;
    $rutaArchivoNuevo = "../src/assets/images/alumno/" . $nombreArchivoNuevo;

    // Verificar si el archivo antiguo existe antes de intentar renombrarlo
    if (file_exists($rutaArchivoAntiguo)) {
        rename($rutaArchivoAntiguo, $rutaArchivoNuevo);
    }else{
        // Si no se ha seleccionado un archivo, asigna la foto predeterminada
        copy('../src/assets/images/alumno/predt.jpg', "../src/assets/images/alumno/" . $dni_al . '.jpg');

    }

    // Continuar con la actualización o redirección
    header('location: ../alumno.php');
}



?>