<?php
// Archivo: registro.php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $is_superuser = isset($_POST['is_superuser']) ? 1 : 0;

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO usuarios (username, password_hash, is_superuser) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $password_hash, $is_superuser);

    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <form method="POST" action="">
        Usuario: <input type="text" name="username" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <input type="checkbox" name="is_superuser"> Superusuario<br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
