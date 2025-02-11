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

/**
 * Función para almacenar en caché con el TTL correcto
 */
function setCache($key, $value) {
    global $redis;

    // Si el valor es un array, verificamos si contiene números o textos
    if (is_array($value)) {
        $is_numeric = true;
        foreach ($value as $item) {
            if (!is_numeric($item)) {
                $is_numeric = false;
                break;
            }
        }
        $ttl = $is_numeric ? 10 : 60; // Numérico → 10s, Texto → 60s
    } elseif (is_numeric($value)) {
        $ttl = 10; // Claves numéricas
    } else {
        $ttl = 60; // Claves de texto
    }

    // Guardar en Redis con el TTL correcto
    $redis->setex($key, $ttl, json_encode($value));
    error_log("✅ Guardado en Redis: $key con TTL de $ttl segundos");
}

/**
 * Función para obtener datos desde Redis
 */
function getCache($key) {
    global $redis;
    $data = $redis->get($key);
    return $data ? json_decode($data, true) : null;
}
?>
