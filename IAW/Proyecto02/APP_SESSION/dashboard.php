<?php
session_start();
include 'db.php';

// Verificar si el usuario está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verificar inactividad de sesión
if (time() - $_SESSION['last_activity'] > 300) { // 5 minutos
    session_destroy();
    header("Location: login.php");
    exit;
}
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

    <?php if ($_SESSION['is_superuser']): ?>
        <h2>Opciones de Superusuario</h2>
        <a href="ver_usuarios.php">Gestionar Usuarios</a>
    <?php else: ?>
        <h2>Opciones de Usuario</h2>
        <a href="juego.php">Jugar</a>
        <a href="ranking.php">Ver Ranking</a>
    <?php endif; ?>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
