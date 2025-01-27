<?php
// Archivo: login.php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id, password_hash, is_superuser FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $password_hash, $is_superuser);

    if ($stmt->fetch() && password_verify($password, $password_hash)) {
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['is_superuser'] = $is_superuser;
        $_SESSION['last_activity'] = time();

        header("Location: dashboard.php");
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        Usuario: <input type="text" name="username" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>