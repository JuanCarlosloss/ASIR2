<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';

// Obtener lista de Olivos desde Redis o MySQL
$olivos = getCache("olivos");

if (!$olivos) {
    error_log("🚨 Olivos no encontrados en Redis. Consultando MySQL...");
    $result = $conn->query("SELECT * FROM olivos");
    $olivos = $result->fetch_all(MYSQLI_ASSOC);
    setCache("olivos", $olivos);
} else {
    error_log("✅ Lista de olivos obtenida desde Redis.");
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
</head>
<body class="container mt-5">
    <h2>Consulta de Olivos</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <h3>Lista de Olivos</h3>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Ubicación</th></tr></thead>
        <tbody>
            <?php foreach ($olivos as $olivo) : ?>
                <tr>
                    <td><?= htmlspecialchars($olivo['id']) ?></td>
                    <td><?= htmlspecialchars($olivo['ubicacion']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
