<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

$error_message = "";
$success_message = "";

// Obtener configuración de la política activa
$config = json_decode($redis->get("configuracion_cache"), true);
$politica_activa = isset($config['politica']) ? $config['politica'] : 'ttl';
$ttl_actual = isset($config['ttl']) ? intval($config['ttl']) : 60;

// **Función para manejar la caché de relaciones**
function obtenerRelaciones() {
    global $conn, $redis, $politica_activa, $ttl_actual;

    $cacheKey = "relaciones";
    $relaciones = json_decode($redis->get($cacheKey), true);

    if (!$relaciones) {
        $relaciones = $conn->query("SELECT vo.vareador_id, v.nombre AS vareador, vo.olivo_id, o.ubicacion AS olivo 
                                   FROM vareadores_olivos vo
                                   JOIN vareadores v ON vo.vareador_id = v.id
                                   JOIN olivos o ON vo.olivo_id = o.id")
                           ->fetch_all(MYSQLI_ASSOC);

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

// Obtener lista de vareadores y olivos
$vareadores = $conn->query("SELECT id, nombre FROM vareadores")->fetch_all(MYSQLI_ASSOC);
$olivos = $conn->query("SELECT id, ubicacion FROM olivos")->fetch_all(MYSQLI_ASSOC);

// Obtener relaciones de Redis o MySQL
$relaciones = obtenerRelaciones();

// **Añadir Relación**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["vareador_id"], $_POST["olivo_id"])) {
    $vareador_id = intval($_POST["vareador_id"]);
    $olivo_id = intval($_POST["olivo_id"]);
    
    $conn->query("INSERT INTO vareadores_olivos (vareador_id, olivo_id) VALUES ($vareador_id, $olivo_id)");

    $relaciones = obtenerRelaciones();
    $success_message = "✅ Relación añadida.";
}

// **Eliminar Relación**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_vareador"], $_POST["eliminar_olivo"])) {
    $vareador_id = intval($_POST["eliminar_vareador"]);
    $olivo_id = intval($_POST["eliminar_olivo"]);

    $conn->query("DELETE FROM vareadores_olivos WHERE vareador_id=$vareador_id AND olivo_id=$olivo_id");

    $relaciones = obtenerRelaciones();
    $success_message = "✅ Relación eliminada.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Relaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 700px; margin-top: 50px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); }
        .btn-custom { width: 100%; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔗 Gestión de Relaciones</h2>
        <hr>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php elseif ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <!-- 📌 Formulario para Agregar Relación -->
        <h4>➕ Añadir Relación</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Seleccionar Vareador:</label>
                <select name="vareador_id" class="form-select">
                    <?php foreach ($vareadores as $v): ?>
                        <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Seleccionar Olivo:</label>
                <select name="olivo_id" class="form-select">
                    <?php foreach ($olivos as $o): ?>
                        <option value="<?= $o['id'] ?>"><?= htmlspecialchars($o['ubicacion']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-custom">Agregar</button>
        </form>

        <!-- 📌 Lista de Relaciones -->
        <h4 class="mt-4">📋 Relaciones Existentes</h4>
        <ul class="list-group mb-3">
            <?php foreach ($relaciones as $r): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>👷 <?= htmlspecialchars($r['vareador']) ?> - 🌿 <?= htmlspecialchars($r['olivo']) ?></span>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="eliminar_vareador" value="<?= $r['vareador_id'] ?>">
                        <input type="hidden" name="eliminar_olivo" value="<?= $r['olivo_id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        <a href="index.php" class="btn btn-secondary btn-custom">Volver</a>
    </div>
</body>
</html>
