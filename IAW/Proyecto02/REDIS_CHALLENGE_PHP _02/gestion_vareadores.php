<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

$error_message = "";
$vareador = null;

// Obtener lista de Vareadores sin guardarlos en Redis
$result = $conn->query("SELECT id, nombre FROM vareadores");
$vareadores_lista = $result->fetch_all(MYSQLI_ASSOC);

// Si el usuario selecciona un Vareador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscar_id"])) {
    $id = intval($_POST["buscar_id"]);
    
    // Intentamos obtener desde Redis
    $vareador = getCache("vareador:$id");

    if (!$vareador) {
        // Si no está en Redis, obtenemos desde MySQL
        $result = $conn->query("SELECT * FROM vareadores WHERE id=$id");
        $vareador = $result->fetch_assoc();

        // Guardamos en Redis si la política es Invalidación de Caché
        if ($config['politica'] == 'invalidacion') {
            setCache("vareador:$id", $vareador);
        }
    }
}

// Si el usuario edita un Vareador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_id"], $_POST["nombre"])) {
    $id = intval($_POST["editar_id"]);
    $nombre = trim($_POST["nombre"]);

    if (!empty($nombre)) {
        $conn->query("UPDATE vareadores SET nombre='$nombre' WHERE id=$id");

        // Aplicar política de caché
        manejarCache("vareador:$id", ["id" => $id, "nombre" => $nombre], 'update');

        header("Location: gestion_vareadores.php?success=edit");
        exit;
    } else {
        $error_message = "❌ El nombre no puede estar vacío.";
    }
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
</head>
<body class="container mt-5">
    <h2>Gestión de Vareadores</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <?php if (!empty($error_message)): ?>
        <p class="alert alert-danger"><?= $error_message ?></p>
    <?php endif; ?>

    <h3>Seleccionar Vareador</h3>
    <form method="post" class="mb-4">
        <label class="form-label">Vareador:</label>
        <select name="buscar_id" class="form-control">
            <option value="" disabled selected>Selecciona un Vareador</option>
            <?php foreach ($vareadores_lista as $v): ?>
                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nombre']) ?> (ID: <?= $v['id'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-info mt-2">Buscar</button>
    </form>

    <?php if ($vareador): ?>
        <h3>Editar Vareador</h3>
        <form method="post">
            <input type="hidden" name="editar_id" value="<?= $vareador['id'] ?>">
            <div class="mb-3">
                <label class="form-label">Nuevo Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($vareador['nombre']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    <?php endif; ?>
</body>
</html>
