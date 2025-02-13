<?php
require_once 'db.php';

// Obtener lista de Vareadores
$vareadores = getCache("vareadores");
if (!$vareadores) {
    $result = $conn->query("SELECT * FROM vareadores");
    $vareadores = $result->fetch_all(MYSQLI_ASSOC);
    setCache("vareadores", $vareadores);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de Vareadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Consulta de Vareadores</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <h3>Lista de Vareadores</h3>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Nombre</th></tr></thead>
        <tbody>
            <?php foreach ($vareadores as $vareador) : ?>
                <tr>
                    <td><?= htmlspecialchars($vareador['id']) ?></td>
                    <td><?= htmlspecialchars($vareador['nombre']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
