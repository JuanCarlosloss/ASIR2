<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

$error_message = "";
$olivo = null;

// Obtener lista de Olivos sin guardarlos en Redis
$result = $conn->query("SELECT id, ubicacion FROM olivos");
$olivos_lista = $result->fetch_all(MYSQLI_ASSOC);

// Si el usuario selecciona un Olivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscar_id"])) {
    $id = intval($_POST["buscar_id"]);
    
    // Intentamos obtener desde Redis
    $olivo = getCache("olivo:$id");

    if (!$olivo) {
        // Si no está en Redis, obtenemos desde MySQL
        $result = $conn->query("SELECT * FROM olivos WHERE id=$id");
        $olivo = $result->fetch_assoc();

        // Guardamos en Redis si la política es Invalidación de Caché
        if ($config['politica'] == 'invalidacion') {
            setCache("olivo:$id", $olivo);
        }
    }
}

// Si el usuario edita un Olivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_id"], $_POST["ubicacion"])) {
    $id = intval($_POST["editar_id"]);
    $ubicacion = trim($_POST["ubicacion"]);

    if (!empty($ubicacion)) {
        $conn->query("UPDATE olivos SET ubicacion='$ubicacion' WHERE id=$id");

        // Aplicar política de caché
        manejarCache("olivo:$id", ["id" => $id, "ubicacion" => $ubicacion], 'update');

        header("Location: gestion_olivos.php?success=edit");
        exit;
    } else {
        $error_message = "❌ La ubicación no puede estar vacía.";
    }
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
</head>
<body class="container mt-5">
    <h2>Gestión de Olivos</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <?php if (!empty($error_message)): ?>
        <p class="alert alert-danger"><?= $error_message ?></p>
    <?php endif; ?>

    <h3>Seleccionar Olivo</h3>
    <form method="post" class="mb-4">
        <label class="form-label">Olivo:</label>
        <select name="buscar_id" class="form-control">
            <option value="" disabled selected>Selecciona un Olivo</option>
            <?php foreach ($olivos_lista as $o): ?>
                <option value="<?= $o['id'] ?>"><?= htmlspecialchars($o['ubicacion']) ?> (ID: <?= $o['id'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-info mt-2">Buscar</button>
    </form>

    <?php if ($olivo): ?>
        <h3>Editar Olivo</h3>
        <form method="post">
            <input type="hidden" name="editar_id" value="<?= $olivo['id'] ?>">
            <div class="mb-3">
                <label class="form-label">Nueva Ubicación</label>
                <input type="text" name="ubicacion" class="form-control" value="<?= htmlspecialchars($olivo['ubicacion']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    <?php endif; ?>
</body>
</html>
