<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_exception_handler(function($exception) {
    echo "Mi Excepción: " . $exception->getMessage();
});
?>

<?php


$host = 'localhost';
$dbname = 'BD_GAMES';
$user = 'root';
$password = '232425'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
