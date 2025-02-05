<?php
require 'db.php';

// Agregar una relación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vareador_id = $_POST["vareador_id"];
    $olivo_id = $_POST["olivo_id"];

    $sql = "INSERT INTO vareadores_olivos (vareador_id, olivo_id) VALUES ('$vareador_id', '$olivo_id')";
    $conn->query($sql);

    // Eliminar la caché de relaciones para actualizarla
    $redis->del("relaciones");
}

// Obtener lista de Vareadores
$vareadores_result = $conn->query("SELECT * FROM vareadores");
$vareadores = $vareadores_result->fetch_all(MYSQLI_ASSOC);

// Obtener lista de Olivos
$olivos_result = $conn->query("SELECT * FROM olivos");
$olivos = $olivos_result->fetch_all(MYSQLI_ASSOC);

// Obtener relaciones desde Redis o MySQL
$relaciones = getCache("relaciones");

if (!$relaciones) {
    error_log("🚨 Relaciones no encontradas en Redis. Consultando MySQL...");

    $query = "SELECT v.nombre AS vareador, o.ubicacion AS olivo 
              FROM vareadores_olivos 
              JOIN vareadores v ON v.id = vareadores_olivos.vareador_id 
              JOIN olivos o ON o.id = vareadores_olivos.olivo_id";

    $relaciones_result = $conn->query($query);
    $relaciones = $relaciones_result->fetch_all(MYSQLI_ASSOC);

    // Guardar en Redis con TTL de 60 segundos
    if (!empty($relaciones)) {
        setCache("relaciones", $relaciones, 60);
        error_log("✅ Relaciones guardadas en Redis.");
    } else {
        error_log("⚠️ No se encontraron relaciones en MySQL.");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relaciones Vareadores - Olivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Relacionar Vareador con Olivo</h2>

    <a href="index.php" class="btn btn-secondary mb-3">Volver</a>

    <form method="post" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Selecciona un Vareador:</label>
            <select name="vareador_id" class="form-control" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($vareadores as $vareador) : ?>
                    <option value="<?= $vareador['id'] ?>"><?= $vareador['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Selecciona un Olivo:</label>
            <select name="olivo_id" class="form-control" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($olivos as $olivo) : ?>
                    <option value="<?= $olivo['id'] ?>"><?= $olivo['ubicacion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Relacionar</button>
    </form>

    <h3>Relaciones Existentes</h3>
    <table class="table table-striped">
        <thead>
            <tr><th>Vareador</th><th>Olivo</th></tr>
        </thead>
        <tbody>
            <?php foreach ($relaciones as $relacion) : ?>
                <tr><td><?= $relacion['vareador'] ?></td><td><?= $relacion['olivo'] ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
