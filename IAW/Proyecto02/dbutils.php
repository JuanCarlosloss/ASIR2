<?php

function conectarDB(): PDO
{
    $db= new PDO("mysql:host=localhost;dbname=DB_EVA2;",username:"root",password:"232425");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function realizarQuery($conexion,$texto,$argumentos=null,$isfetch=false): mixed
{
    $comand=$conexion->prepare($texto);
    $comand->execute($argumentos);
    if($isfetch) return $comand->fetchAll();
}

?>