<?php 
$cn=mysqli_connect("localhost", "root", "","bd_zeus2024");
mysqli_set_charset($cn, "utf8");
if (!$cn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>