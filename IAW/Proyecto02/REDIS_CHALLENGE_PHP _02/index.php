<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); text-align: center; }
        .btn-custom { width: 100%; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🌿 Aplicación de Gestión de Olivos y Vareadores</h2>
        <hr>

        <h4>📌 Gestión</h4>
        <a href="gestion_vareadores.php" class="btn btn-primary btn-custom">👷 Gestión de Vareadores</a>
        <a href="gestion_olivos.php" class="btn btn-success btn-custom">🌳 Gestión de Olivos</a>
        <a href="relaciones.php" class="btn btn-warning btn-custom">🔗 Gestión de Relaciones</a>

        <h4 class="mt-4">🔍 Consultas</h4>
        <a href="consulta_vareadores.php" class="btn btn-info btn-custom">👷‍♂️ Consultar Vareadores</a>
        <a href="consulta_olivos.php" class="btn btn-secondary btn-custom">🌿 Consultar Olivos</a>
        <a href="buscar.php" class="btn btn-dark btn-custom">🔍 Buscar Relaciones</a>

        <h4 class="mt-4">⚙️ Configuración</h4>
        <a href="configuracion.php" class="btn btn-danger btn-custom">⚙️ Configuración de Caché</a>
    </div>
</body>
</html>
