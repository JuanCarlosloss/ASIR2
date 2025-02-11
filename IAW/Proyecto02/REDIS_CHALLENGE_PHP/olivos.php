<?php
require 'db.php';

// Agregar un Olivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ubicacion"])) {
    $ubicacion = $_POST["ubicacion"];
    $conn->query("INSERT INTO olivos (ubicacion) VALUES ('$ubicacion')");
    $redis->del("olivos");
}

// Modificar un Olivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_id"])) {
    $id = $_POST["editar_id"];
    $nueva_ubicacion = $_POST["nueva_ubicacion"];
    $conn->query("UPDATE olivos SET ubicacion='$nueva_ubicacion' WHERE id=$id");
    $redis->del("olivos");
}

// Eliminar un Olivo
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM olivos WHERE id=$id");
    $redis->del("olivos");
}

// Obtener la lista desde Redis o MySQL
$olivos = getCache("olivos");
if (!$olivos) {
    $result = $conn->query("SELECT * FROM olivos");
    $olivos = $result->fetch_all(MYSQLI_ASSOC);
    setCache("olivos", $olivos);
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Olivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Olivos</h2>

    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <form method="post" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Ubicación del Olivo</label>
            <input type="text" name="ubicacion" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>

    <h3>Lista de Olivos</h3>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Ubicación</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php foreach ($olivos as $olivo) : ?>
                <tr>
                    <td><?= $olivo['id'] ?></td>
                    <td><?= $olivo['ubicacion'] ?></td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="editar_id" value="<?= $olivo['id'] ?>">
                            <input type="text" name="nueva_ubicacion" placeholder="Nueva ubicación" required>
                            <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                        </form>
                        <a href="?eliminar=<?= $olivo['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este Olivo?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
