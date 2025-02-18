<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Vareadores y Olivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-box {
            max-width: 450px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
            margin-top: 40px;
            text-align: center;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 20px;
        }
        .btn-custom {
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container-box">
        <h2 class="title">Gestión de Vareadores y Olivos</h2>

        <div class="d-grid gap-3">
            <a href="vareadores.php" class="btn btn-primary btn-custom">Gestionar Vareadores</a>
            <a href="olivos.php" class="btn btn-success btn-custom">Gestionar Olivos</a>
            <a href="relaciones.php" class="btn btn-warning btn-custom">Gestionar Relaciones</a>
            <a href="buscar.php" class="btn btn-dark btn-custom">Buscar Relaciones</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
