<?php
// Archivo: juego.php
session_start();
include 'db.php';

// Validar que el usuario esté logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Inicializar variables
if (!isset($_SESSION['numero_oculto'])) {
    $_SESSION['numero_oculto'] = rand(1, 100);
    $_SESSION['intentos'] = 0;
}

// Procesar intentos
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $intento = intval($_POST['intento']);
    $_SESSION['intentos']++;

    if ($intento > $_SESSION['numero_oculto']) {
        $mensaje = "El número es menor.";
    } elseif ($intento < $_SESSION['numero_oculto']) {
        $mensaje = "El número es mayor.";
    } else {
        $mensaje = "¡Felicidades! Adivinaste el número en {$_SESSION['intentos']} intentos.";
        $juego_finalizado = true;
    }
}

// Reset del juego
if (isset($juego_finalizado) && isset($_POST['reiniciar'])) {
    $_SESSION['numero_oculto'] = rand(1, 100);
    $_SESSION['intentos'] = 0;
    unset($juego_finalizado);
    $mensaje = "¡Nuevo número generado!";
}

// Registrar ranking
if (isset($juego_finalizado) && isset($_POST['guardar_ranking'])) {
    $usuario_id = $_SESSION['user_id'];
    $intentos = $_SESSION['intentos'];

    $stmt = $db->prepare("INSERT INTO ranking (usuario_id, puntos) VALUES (?, ?)");
    $stmt->bind_param("ii", $usuario_id, $intentos);
    $stmt->execute();

    $mensaje = "¡Tus puntos se guardaron en el ranking!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Juego - Número Oculto</title>
</head>
<body>
    <h1>¡Adivina el número oculto!</h1>
    <p><?php echo $mensaje; ?></p>

    <?php if (!isset($juego_finalizado)): ?>
        <form method="POST" action="">
            <input type="number" name="intento" min="1" max="100" required>
            <button type="submit">Intentar</button>
        </form>
    <?php else: ?>
        <form method="POST" action="">
            <button name="reiniciar">Reiniciar juego</button>
            <button name="guardar_ranking">Guardar en ranking</button>
        </form>
    <?php endif; ?>

    <a href="dashboard.php">Regresar al dashboard</a>
</body>
</html>
