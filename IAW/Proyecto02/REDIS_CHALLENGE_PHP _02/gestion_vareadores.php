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

// Obtener lista de Vareadores
$result = $conn->query("SELECT id, nombre FROM vareadores");
$vareadores_lista = $result->fetch_all(MYSQLI_ASSOC);

// **Editar Vareador**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_id"], $_POST["nombre"])) {
    $id = intval($_POST["editar_id"]);
    $nombre = trim($_POST["nombre"]);

    if (!empty($nombre)) {
        $conn->query("UPDATE vareadores SET nombre='$nombre' WHERE id=$id");

        // ✅ Si la política `write_through` está activa, actualiza Redis inmediatamente
        if ($politica_activa === "write_through") {
            setCache("vareadores", $conn->query("SELECT * FROM vareadores")->fetch_all(MYSQLI_ASSOC));
        }

        $success_message = "✅ Vareador actualizado.";
    } else {
        $error_message = "❌ El nombre no puede estar vacío.";
    }
}

// **Añadir Vareador**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nuevo_nombre"])) {
    $nombre = trim($_POST["nuevo_nombre"]);

    if (!empty($nombre)) {
        $conn->query("INSERT INTO vareadores (nombre) VALUES ('$nombre')");

        // ✅ Si `write_through` está activa, actualiza Redis inmediatamente
        if ($politica_activa === "write_through") {
            setCache("vareadores", $conn->query("SELECT * FROM vareadores")->fetch_all(MYSQLI_ASSOC));
        }

        $success_message = "✅ Vareador añadido.";
    } else {
        $error_message = "❌ El nombre no puede estar vacío.";
    }
}

// **Eliminar Vareador**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_id"])) {
    $id = intval($_POST["eliminar_id"]);
    $conn->query("DELETE FROM vareadores WHERE id=$id");

    // ✅ Si `write_through` está activa, actualiza Redis inmediatamente
    if ($politica_activa === "write_through") {
        setCache("vareadores", $conn->query("SELECT * FROM vareadores")->fetch_all(MYSQLI_ASSOC));
    }

    $success_message = "✅ Vareador eliminado.";
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Vareadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); }
        .btn-custom { width: 100%; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>👷 Gestión de Vareadores</h2>
        <hr>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php elseif ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <!-- 📌 Formulario para Agregar un Vareador -->
        <h4>➕ Agregar Nuevo Vareador</h4>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="nuevo_nombre" class="form-control" placeholder="Nombre del Vareador">
            </div>
            <button type="submit" class="btn btn-success btn-custom">Agregar</button>
        </form>

        <!-- 📌 Lista de Vareadores con opciones de Editar y Eliminar -->
        <h4 class="mt-4">📋 Lista de Vareadores</h4>
        <ul class="list-group mb-3">
            <?php foreach ($vareadores_lista as $v): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($v['nombre']) ?></span>
                    <div>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="editar_id" value="<?= $v['id'] ?>">
                            <input type="text" name="nombre" value="<?= htmlspecialchars($v['nombre']) ?>" class="form-control d-inline" style="width: 150px;">
                            <button type="submit" class="btn btn-warning btn-sm">✏️</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="eliminar_id" value="<?= $v['id'] ?>">
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