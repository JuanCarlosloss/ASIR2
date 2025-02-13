<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Obtener configuración de caché desde Redis o MySQL
$config = json_decode($redis->get("configuracion_cache"), true);
if (!$config) {
    $result = $conn->query("SELECT politica, ttl FROM configuracion_cache LIMIT 1");
    $config = $result->fetch_assoc();
    $redis->set("configuracion_cache", json_encode($config)); // Guardar en Redis
}

// Función para obtener datos desde Redis
if (!function_exists('getCache')) {
    function getCache($key) {
        global $redis;
        $data = $redis->get($key);
        return $data ? json_decode($data, true) : null;
    }
}

// Función para guardar datos en Redis con TTL según la política
if (!function_exists('setCache')) {
    function setCache($key, $value) {
        global $redis, $config;

        if ($config['politica'] == 'ttl' && isset($config['ttl'])) {
            $ttl = intval($config['ttl']);
            $redis->setex($key, $ttl, json_encode($value));
        } else {
            $redis->set($key, json_encode($value));
        }
    }
}

// Función para manejar la caché según la política seleccionada
if (!function_exists('manejarCache')) {
    function manejarCache($key, $value = null, $accion = 'update') {
        global $redis, $config;

        switch ($config['politica']) {
            case 'write_through': // Actualización Inmediata
                if ($accion === 'delete') {
                    $redis->del($key);
                } else {
                    $redis->set($key, json_encode($value));
                }
                break;

            case 'invalidacion': // Invalidación de Caché
                if ($accion === 'delete' || $accion === 'update') {
                    $redis->del($key);
                }
                break;

            case 'ttl': // Expiración automática
                if ($value !== null) {
                    $redis->setex($key, intval($config['ttl']), json_encode($value));
                }
                break;

            case 'lazy_loading': // Carga diferida
                if ($value === null) {
                    return json_decode($redis->get($key), true);
                }
                $redis->set($key, json_encode($value));
                break;

            case 'gilran': // Gilbert Random
                if ($value !== null) {
                    $redis->set($key, json_encode($value));
                }
                $keys = $redis->keys("*");
                foreach ($keys as $k) {
                    if (rand(0, 1) === 1) {
                        $redis->del($k);
                    }
                }
                break;
        }
    }
}
?>
