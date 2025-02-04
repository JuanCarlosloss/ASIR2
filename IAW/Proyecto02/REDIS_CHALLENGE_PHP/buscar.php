<?php
require 'db.php';

$buscar = "";
$resultado = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buscar = $_POST["buscar"];
    
    // Buscar Vareador y sus Olivos
    $sql = "SELECT v.nombre AS vareador, o.ubicacion AS olivo 
            FROM vareadores_olivos 
            JOIN vareadores v ON v.id = vareadores_olivos.vareador_id 
            JOIN olivos o ON o.id = vareadores_olivos.olivo_id 
            WHERE v.nombre LIKE '%$buscar%' OR o.ubicacion LIKE '%$buscar%'";
    
    $query_result = $conn->query($sql);
    $resultado = $query_result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Relaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Buscar Relaciones</h2>

    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <form method="post" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Buscar por Vareador o Ubicación del Olivo</label>
            <input type="text" name="buscar" class="form-control" value="<?= htmlspecialchars($buscar) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <?php if (!empty($resultado)) : ?>
        <h3>Resultados de la Búsqueda</h3>
        <table class="table table-striped">
            <thead>
                <tr><th>Vareador</th><th>Olivo</th></tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $relacion) : ?>
                    <tr><td><?= $relacion['vareador'] ?></td><td><?= $relacion['olivo'] ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($buscar) : ?>
        <p class="alert alert-warning">No se encontraron resultados.</p>
    <?php endif; ?>
</body>
</html>
