<?php
// Archivo: db.php
$db = new mysqli("localhost", "root", "", "webapp_db");
if ($db->connect_error) {
    die("Conexión fallida: " . $db->connect_error);
}
?>