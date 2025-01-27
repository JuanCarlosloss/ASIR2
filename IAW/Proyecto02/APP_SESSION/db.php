<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$dbname = 'appsession_db';
$user = 'root';
$pass = '232425';

// Conectar a la base de datos
$db = new mysqli($host, $user, $pass, $dbname);

if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}
?>
