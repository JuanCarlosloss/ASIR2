<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

$error_message = "";

// Obtener configuración desde MySQL o Redis
$config = json_decode($redis->get("configuracion_cache"), true);

if (!$config) {
    $result = $conn->query("SELECT politica, ttl FROM configuracion_cache LIMIT 1");
    $config = $result->fetch_assoc();
    $redis->set("configuracion_cache", json_encode($config)); // Guardar en Redis
}

// Si el usuario cambia la configuración
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["politica"])) {
    $politica = $_POST["politica"];
    $ttl = isset($_POST["ttl"]) && is_numeric($_POST["ttl"]) ? intval($_POST["ttl"]) : null;

    if ($politica === "ttl" && ($ttl === null || $ttl <= 0)) {
        $error_message = "❌ Debes ingresar un TTL válido.";
    } else {
        // Guardar en MySQL
        $conn->query("DELETE FROM configuracion_cache");
        $conn->query("INSERT INTO configuracion_cache (politica, ttl) VALUES ('$politica', " . ($ttl ?? 'NULL') . ")");

        // Guardar en Redis con TTL infinito
        $redis->set("configuracion_cache", json_encode(["politica" => $politica, "ttl" => $ttl]));

        header("Location: configuracion.php");
        exit;
    }
}

// Si se solicita borrar la caché de Redis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["borrar_cache"])) {
    $redis->flushAll(); // Borra toda la caché de Redis
    $error_message = "✅ ¡Caché de Redis borrada correctamente!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración de Caché Redis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleTTLField() {
            var politica = document.getElementById("politica").value;
            var ttlField = document.getElementById("ttlField");
            ttlField.style.display = (politica === "ttl") ? "block" : "none";
        }
    </script>
</head>
<body class="container mt-5">
    <h2>Configuración de Caché Redis</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <?php if (!empty($error_message)): ?>
        <p class="alert alert-info"><?= $error_message ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Selecciona la Política de Caché:</label>
            <select name="politica" id="politica" class="form-control" onchange="toggleTTLField()">
                <option value="write_through" <?= ($config['politica'] == 'write_through') ? 'selected' : '' ?>>Actualización Inmediata (Write-Through Cache)</option>
                <option value="invalidacion" <?= ($config['politica'] == 'invalidacion') ? 'selected' : '' ?>>Invalidación de Caché</option>
                <option value="ttl" <?= ($config['politica'] == 'ttl') ? 'selected' : '' ?>>Expiración Automática (TTL)</option>
                <option value="lazy_loading" <?= ($config['politica'] == 'lazy_loading') ? 'selected' : '' ?>>Carga Diferida (Lazy Loading)</option>
                <option value="gilran" <?= ($config['politica'] == 'gilran') ? 'selected' : '' ?>>Gilbert Random (GilRan)</option>
            </select>
        </div>

        <!-- Campo de TTL que solo aparece si la política es "Reemplazo por TTL" -->
        <div class="mb-3" id="ttlField" style="display: <?= ($config['politica'] == 'ttl') ? 'block' : 'none' ?>;">
            <label class="form-label">Tiempo de Vida (TTL en segundos):</label>
            <input type="number" name="ttl" class="form-control" value="<?= htmlspecialchars($config['ttl'] ?? '') ?>">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
    </form>

    <h3 class="mt-4">Borrar Caché de Redis</h3>
    <form method="post">
        <input type="hidden" name="borrar_cache" value="1">
        <button type="submit" class="btn btn-danger">Borrar Caché</button>
    </form>
</body>
</html>
