<?php
$servername = "localhost";
$username = "root";
$password = "232425";
$dbname = "olivos_db";

// Conexión a MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// Conexión a Redis
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

// Función para almacenar en caché con TTL
function setCache($key, $value, $ttl) {
    global $redis;
    $redis->setex($key, $ttl, json_encode($value));
}

// Función para obtener datos de caché
function getCache($key) {
    global $redis;
    $data = $redis->get($key);
    return $data ? json_decode($data, true) : null;
}
?>
