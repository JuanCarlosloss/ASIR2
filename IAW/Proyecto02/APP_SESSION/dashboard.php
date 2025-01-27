<?php
// Archivo: dashboard.php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (time() - $_SESSION['last_activity'] > 300) {
    session_destroy();
    header("Location: login.php");
    exit;
}
$_SESSION['last_activity'] = time();

$is_superuser = $_SESSION['is_superuser'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <p>Bienvenido, <?php echo $is_superuser ? 'Superusuario' : 'Usuario'; ?></p>
    <a href="logout.php">Logout</a>
    <?php if ($is_superuser): ?>
        <h2>Opciones de Superusuario</h2>
        <a href="gestionar_usuarios.php">Gestionar Usuarios</a>
    <?php else: ?>
        <h2>Opciones de Usuario</h2>
        <a href="juego.php">Jugar</a>
        <a href="ranking.php">Ranking</a>
    <?php endif; ?>
</body>
</html>
