<?php
$host="localhost";
    $bd="bd_libros";
    $usuario="root";
    $contrasenia="";

    try {
        $conexion=new PDO("mysql:host=$host;dbname=$bd", $usuario,$contrasenia);
    } catch (Exception $ex) {
        echo "ERROR".$ex->getMessage();
    }
?>