<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

$error_message = "";
$success_message = "";

// Obtener configuración de caché desde Redis
$config = json_decode($redis->get("configuracion_cache"), true);
$politica_activa = isset($config['politica']) ? $config['politica'] : 'ttl';
$ttl = isset($config['ttl']) ? intval($config['ttl']) : 60;

// Obtener lista de Olivos
$result = $conn->query("SELECT id, ubicacion FROM olivos");
$olivos_lista = $result->fetch_all(MYSQLI_ASSOC);

// **Editar Olivo**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_id"], $_POST["ubicacion"])) {
    $id = intval($_POST["editar_id"]);
    $ubicacion = trim($_POST["ubicacion"]);

    if (!empty($ubicacion)) {
        $conn->query("UPDATE olivos SET ubicacion='$ubicacion' WHERE id=$id");

        // ✅ `write_through`: Actualiza Redis inmediatamente
        if ($politica_activa === "write_through") {
            setCache("olivos", $conn->query("SELECT * FROM olivos")->fetch_all(MYSQLI_ASSOC));
        }

        $success_message = "✅ Olivo actualizado.";
    } else {
        $error_message = "❌ La ubicación del olivo no puede estar vacía.";
    }
}

// **Añadir Olivo**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nueva_ubicacion"])) {
    $ubicacion = trim($_POST["nueva_ubicacion"]);

    if (!empty($ubicacion)) {
        $conn->query("INSERT INTO olivos (ubicacion) VALUES ('$ubicacion')");

        // ✅ `write_through`: Actualiza Redis inmediatamente
        if ($politica_activa === "write_through") {
            setCache("olivos", $conn->query("SELECT * FROM olivos")->fetch_all(MYSQLI_ASSOC));
        }

        $success_message = "✅ Olivo añadido.";
    } else {
        $error_message = "❌ La ubicación del olivo no puede estar vacía.";
    }
}

// **Eliminar Olivo**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_id"])) {
    $id = intval($_POST["eliminar_id"]);
    $conn->query("DELETE FROM olivos WHERE id=$id");

    // ✅ `write_through`: Actualiza Redis inmediatamente
    if ($politica_activa === "write_through") {
        setCache("olivos", $conn->query("SELECT * FROM olivos")->fetch_all(MYSQLI_ASSOC));
    }

    $success_message = "✅ Olivo eliminado.";
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Olivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); }
        .btn-custom { width: 100%; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🌿 Gestión de Olivos</h2>
        <hr>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php elseif ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <!-- 📌 Formulario para Agregar un Olivo -->
        <h4>➕ Agregar Nuevo Olivo</h4>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="nuevo_ubicacion" class="form-control" placeholder="Ubicación del olivo">
            </div>
            <button type="submit" class="btn btn-success btn-custom">Agregar</button>
        </form>

        <!-- 📌 Lista de Olivos con opciones de Editar y Eliminar -->
        <h4 class="mt-4">📋 Lista de Olivos</h4>
        <ul class="list-group mb-3">
            <?php foreach ($olivos_lista as $o): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($o['ubicacion']) ?></span>
                    <div>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="editar_id" value="<?= $o['id'] ?>">
                            <input type="text" name="ubicacion" value="<?= htmlspecialchars($o['ubicacion']) ?>" class="form-control d-inline" style="width: 150px;">
                            <button type="submit" class="btn btn-warning btn-sm">✏️</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="eliminar_id" value="<?= $o['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <a href="index.php" class="btn btn-secondary btn-custom">Volver</a>
    </div>
</body>
</html>