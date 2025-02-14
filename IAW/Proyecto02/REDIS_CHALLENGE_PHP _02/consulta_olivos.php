<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

$error_message = "";
$olivos = [];

// Obtener configuración de caché desde Redis
$config = json_decode($redis->get("configuracion_cache"), true);
$politica_activa = isset($config['politica']) ? $config['politica'] : 'ttl';
$ttl = isset($config['ttl']) ? intval($config['ttl']) : 60;

// **Si `invalidacion` está activa, actualiza Redis en cada consulta**
if ($politica_activa === "invalidacion") {
    $result = $conn->query("SELECT * FROM olivos");
    $olivos = $result->fetch_all(MYSQLI_ASSOC);
    setCache("olivos", $olivos);
}
// **Si `ttl` está activa, aplica TTL**
elseif ($politica_activa === "ttl") {
    $result = $conn->query("SELECT * FROM olivos");
    $olivos = $result->fetch_all(MYSQLI_ASSOC);
    setCacheTTL("olivos", $olivos, $ttl);
}
// **Si ninguna política está activa, usa la caché normalmente**
else {
    $olivos = getCache("olivos");

    if (!$olivos) {
        $result = $conn->query("SELECT * FROM olivos");
        $olivos = $result->fetch_all(MYSQLI_ASSOC);
        setCache("olivos", $olivos);
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de Olivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { 
            max-width: 600px; 
            margin-top: 50px; 
            padding: 20px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
            text-align: center;
        }
        .list-group-item { font-size: 18px; font-weight: 500; }
        .list-group-item span { font-size: 22px; margin-right: 10px; }
        .btn-custom { width: 100%; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🌳 Consulta de Olivos</h2>
        <hr>

        <?php if (!empty($olivos)): ?>
            <ul class="list-group">
                <?php foreach ($olivos as $o): ?>
                    <li class="list-group-item">
                        <span>🌿</span> <?= htmlspecialchars($o['ubicacion']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning text-center">⚠️ No hay olivos registrados.</p>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary btn-custom">Volver</a>
    </div>
</body>
</html>