<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

$success_message = "";

// **Borrar Caché si se pulsa el botón**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["borrar_cache"])) {
    $redis->flushAll();
    $success_message = "🗑️ Caché de Redis eliminada correctamente.";
}

// **Guardar configuración si se envía el formulario**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["politica"])) {
    $politica = $_POST['politica'];
    $ttl = isset($_POST['ttl']) ? intval($_POST['ttl']) : 60; // TTL por defecto de 60s

    // Guardar en Redis
    $configuracion = json_encode(["politica" => $politica, "ttl" => $ttl]);
    $redis->set("configuracion_cache", $configuracion);

    $success_message = "✅ Configuración actualizada.";
}

// Obtener configuración actual desde Redis
$config = json_decode($redis->get("configuracion_cache"), true);
$politica_activa = isset($config['politica']) ? $config['politica'] : 'ttl';
$ttl_actual = isset($config['ttl']) ? $config['ttl'] : 60;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración de Caché</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleTTLField() {
            let politica = document.getElementById("politica").value;
            let ttlField = document.getElementById("ttl_field");
            ttlField.style.display = (politica === "ttl") ? "block" : "none";
        }
    </script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">⚙️ Configuración de Caché</h2>
        <hr>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Seleccionar Política de Caché:</label>
                <select name="politica" id="politica" class="form-select" onchange="toggleTTLField()">
                    <option value="write_through" <?= $politica_activa === "write_through" ? "selected" : "" ?>>Actualización Inmediata (Write-Through)</option>
                    <option value="invalidacion" <?= $politica_activa === "invalidacion" ? "selected" : "" ?>>Invalidación de Caché</option>
                    <option value="ttl" <?= $politica_activa === "ttl" ? "selected" : "" ?>>Reemplazo por TTL (Expiración Automática)</option>
                </select>
            </div>

            <div class="mb-3" id="ttl_field" style="display: <?= $politica_activa === "ttl" ? 'block' : 'none' ?>;">
                <label class="form-label">Tiempo de Vida (TTL) en segundos:</label>
                <input type="number" name="ttl" value="<?= $ttl_actual ?>" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary btn-custom">Guardar Configuración</button>
        </form>

        <hr>

        <h4 class="text-center mt-4">🗑️ Borrar Caché de Redis</h4>
        <form method="POST">
            <input type="hidden" name="borrar_cache" value="1">
            <button type="submit" class="btn btn-danger btn-custom">Eliminar Toda la Caché</button>
        </form>

        <a href="index.php" class="btn btn-secondary btn-custom mt-3">Volver</a>
    </div>

    <script>
        toggleTTLField();
    </script>
</body>
</html>
