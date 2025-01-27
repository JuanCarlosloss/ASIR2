<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $is_superuser = isset($_POST['is_superuser']) ? 1 : 0;

    $stmt = $db->prepare("INSERT INTO usuarios (username, password_hash, is_superuser) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $password, $is_superuser);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Error al registrar al usuario.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1>Registro</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <label>
            <input type="checkbox" name="is_superuser"> ¿Superusuario?
        </label>
        <button type="submit">Registrarse</button>
    </form>
    <a href="login.php">Iniciar sesión</a>
</body>
</html>
