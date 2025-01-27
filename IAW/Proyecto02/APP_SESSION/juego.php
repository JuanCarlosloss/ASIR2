<?php
// Archivo: juego.php
session_start();
include 'db.php';

// Verificar que el usuario esté logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Inicializar variables si es la primera vez que se accede al juego
if (!isset($_SESSION['numero_oculto'])) {
    $_SESSION['numero_oculto'] = rand(1, 100);
    $_SESSION['intentos'] = 0;
}

$mensaje = "";

// Procesar intentos del usuario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['intento'])) {
        $intento = intval($_POST['intento']);
        $_SESSION['intentos']++;

        if ($intento > $_SESSION['numero_oculto']) {
            $mensaje = "El número es menor.";
        } elseif ($intento < $_SESSION['numero_oculto']) {
            $mensaje = "El número es mayor.";
        } else {
            $mensaje = "¡Felicidades! Adivinaste el número en {$_SESSION['intentos']} intentos.";
            $juego_finalizado = true; // Marcamos el juego como terminado
        }
    }

    // Guardar en el ranking
    if (isset($_POST['guardar_ranking'])) {
        $usuario_id = $_SESSION['user_id'];
        $intentos = $_SESSION['intentos'];

        $stmt = $db->prepare("INSERT INTO ranking (usuario_id, puntos, fecha) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $usuario_id, $intentos);

        if ($stmt->execute()) {
            $mensaje = "¡Tus puntos se guardaron correctamente en el ranking!";
        } else {
            $mensaje = "Hubo un error al guardar tus puntos en el ranking.";
        }

        // Reiniciar el juego después de guardar
        $_SESSION['numero_oculto'] = rand(1, 100);
        $_SESSION['intentos'] = 0;
        unset($juego_finalizado);
    }

    // Reiniciar el juego
    if (isset($_POST['reiniciar'])) {
        $_SESSION['numero_oculto'] = rand(1, 100);
        $_SESSION['intentos'] = 0;
        unset($juego_finalizado);
        $mensaje = "¡Nuevo juego iniciado!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Juego - Número Oculto</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1>¡Adivina el número oculto!</h1>
    <p><?php echo htmlspecialchars($mensaje); ?></p>

    <?php if (!isset($juego_finalizado)): ?>
        <form method="POST" action="">
            <input type="number" name="intento" min="1" max="100" placeholder="Tu número" required>
            <button type="submit">Intentar</button>
        </form>
    <?php else: ?>
        <p>¡Juego terminado! Número de intentos: <?php echo $_SESSION['intentos']; ?></p>
        <form method="POST" action="">
            <button name="guardar_ranking" type="submit">Guardar en el ranking</button>
            <button name="reiniciar" type="submit">Jugar de nuevo</button>
        </form>
    <?php endif; ?>

    <a href="dashboard.php">Regresar al Dashboard</a>
</body>
</html>
