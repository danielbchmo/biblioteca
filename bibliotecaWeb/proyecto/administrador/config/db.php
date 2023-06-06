<?php

$host="localhost";
$db="id19465532_proyecto";
$usuario="id19465532_proyecto1";
$contrasenia="BvQ98SpVMCh|h8kJ";

try {
    $conexion=new PDO ("mysql:host=$host;dbname=$db",$usuario,$contrasenia);
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
