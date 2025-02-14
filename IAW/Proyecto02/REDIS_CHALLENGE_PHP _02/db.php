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

// **Función para guardar en Redis sin TTL**
function setCache($key, $value) {
    global $redis;
    $redis->set($key, json_encode($value));
    error_log("📥 Guardado en Redis: $key");
}

// **Función para guardar en Redis con TTL**
function setCacheTTL($key, $value, $ttl) {
    global $redis;
    $redis->setex($key, $ttl, json_encode($value));
    error_log("🕒 Guardado en Redis con TTL de $ttl segundos: $key");
}

// **Función para obtener de Redis**
function getCache($key) {
    global $redis;
    $data = $redis->get($key);
    return $data ? json_decode($data, true) : null;
}

// **Función para eliminar clave en Redis**
function deleteCache($key) {
    global $redis;
    $redis->del($key);
    error_log("🗑️ Eliminado de Redis: $key");
}

// Obtener configuración de caché
$config = json_decode($redis->get("configuracion_cache"), true);
$politica_activa = isset($config['politica']) ? $config['politica'] : 'ttl';
?>
