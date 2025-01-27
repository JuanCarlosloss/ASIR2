<?php
// Archivo: logout.php
session_start();
session_destroy();
header("Location: login.php");
?>

<?php
// Archivo: juego.php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
// Lógica del juego (placeholder)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Juego</title>
</head>
<body>
    <p>Implementa el juego del número oculto aquí.</p>
    <a href="dashboard.php">Regresar</a>
</body>
</html>

<?php
// Archivo: ranking.php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ranking</title>
</head>
<body>
    <p>Mostrar y agregar al ranking aquí.</p>
    <a href="dashboard.php">Regresar</a>
</body>
</html>
