<?php
require 'db.php';

// Agregar un nuevo Vareador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
    $nombre = $_POST["nombre"];
    $conn->query("INSERT INTO vareadores (nombre) VALUES ('$nombre')");
    $redis->del("vareadores"); // Eliminar caché para actualizar datos
}

// Modificar Vareador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_id"])) {
    $id = $_POST["editar_id"];
    $nuevo_nombre = $_POST["nuevo_nombre"];
    $conn->query("UPDATE vareadores SET nombre='$nuevo_nombre' WHERE id=$id");
    $redis->del("vareadores"); // Limpiar caché
}

// Eliminar Vareador
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM vareadores WHERE id=$id");
    $redis->del("vareadores"); // Limpiar caché
}

// Obtener lista de Vareadores desde Redis o MySQL
$vareadores = getCache("vareadores");
if (!$vareadores) {
    $result = $conn->query("SELECT * FROM vareadores");
    $vareadores = $result->fetch_all(MYSQLI_ASSOC);
    setCache("vareadores", $vareadores, 60); // TTL de 60 segundos
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vareadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Vareadores</h2>

    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <form method="post" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Nombre del Vareador</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>

    <h3>Lista de Vareadores</h3>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php foreach ($vareadores as $vareador) : ?>
                <tr>
                    <td><?= $vareador['id'] ?></td>
                    <td><?= $vareador['nombre'] ?></td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="editar_id" value="<?= $vareador['id'] ?>">
                            <input type="text" name="nuevo_nombre" placeholder="Nuevo nombre" required>
                            <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                        </form>
                        <a href="?eliminar=<?= $vareador['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este Vareador?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
