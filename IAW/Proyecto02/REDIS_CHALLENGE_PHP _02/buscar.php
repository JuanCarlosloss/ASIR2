<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

$error_message = "";
$resultados = [];
$busqueda = "";

// Obtener la configuración de la política activa
$config = json_decode($redis->get("configuracion_cache"), true);
$politica_activa = isset($config['politica']) ? $config['politica'] : 'ttl';
$ttl_actual = isset($config['ttl']) ? intval($config['ttl']) : 60;

// **Función para buscar relaciones en Redis o MySQL**
function buscarRelaciones($busqueda) {
    global $conn, $redis, $politica_activa, $ttl_actual;

    $cacheKey = "buscar_relaciones_" . $busqueda; // 🔥 Quitamos el md5 y dejamos el texto normal
    $relaciones = json_decode($redis->get($cacheKey), true);

    if (!$relaciones) {
        $sql = "SELECT v.nombre AS vareador, o.ubicacion AS olivo 
                FROM vareadores_olivos vo
                JOIN vareadores v ON vo.vareador_id = v.id
                JOIN olivos o ON vo.olivo_id = o.id
                WHERE v.nombre LIKE ? OR o.ubicacion LIKE ?";
                
        $stmt = $conn->prepare($sql);
        $busquedaParam = "%$busqueda%";
        $stmt->bind_param("ss", $busquedaParam, $busquedaParam);
        $stmt->execute();
        $result = $stmt->get_result();
        $relaciones = $result->fetch_all(MYSQLI_ASSOC);

        switch ($politica_activa) {
            case "write_through":
                $redis->set($cacheKey, json_encode($relaciones));
                break;
            case "invalidacion":
                $redis->del($cacheKey);
                break;
            case "ttl":
                $redis->setex($cacheKey, $ttl_actual, json_encode($relaciones));
                break;
        }
    }

    return $relaciones;
}

// **Manejo del formulario de búsqueda**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['busqueda'])) {
    $busqueda = trim($_POST['busqueda']);
    $resultados = buscarRelaciones($busqueda);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Relaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { 
            max-width: 700px; 
            margin-top: 50px; 
            padding: 20px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
            text-align: center;
        }
        .list-group-item { font-size: 18px; font-weight: 500; }
        .btn-custom { width: 100%; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔍 Buscar Relaciones</h2>
        <hr>

        <!-- Formulario de Búsqueda -->
        <form method="POST">
            <div class="input-group mb-3">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar por vareador u olivo..." value="<?= htmlspecialchars($busqueda) ?>">
                <button class="btn btn-primary" type="submit">🔍 Buscar</button>
            </div>
        </form>

        <!-- Resultados -->
        <?php if (!empty($resultados)): ?>
            <h4 class="mt-4">📋 Resultados</h4>
            <ul class="list-group">
                <?php foreach ($resultados as $r): ?>
                    <li class="list-group-item">
                        👷‍♂️ <?= htmlspecialchars($r['vareador']) ?> - 🌿 <?= htmlspecialchars($r['olivo']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p class="text-warning text-center">⚠️ No se encontraron relaciones.</p>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary btn-custom">Volver</a>
    </div>
</body>
</html>
