<?php

$servidor="localhost";
$baseDatos="capacitacion";
$usuario="root";
$contranenia="";

try{
    $conexion=new PDO("mysql:host=$servidor;dbname=$baseDatos", $usuario, $contranenia);
}catch(Exception $error){
    echo $error->getMessage();
}

?>