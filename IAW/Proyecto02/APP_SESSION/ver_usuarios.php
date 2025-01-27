<?php
session_start();
include 'db.php';

// Verificar si el usuario está autenticado y tiene permisos de superusuario
if (!isset($_SESSION['user_id']) || !$_SESSION['is_superuser']) {
    header("Location: login.php");
    exit;
}

// Manejar la eliminación de usuarios
if (isset($_GET['accion']) && $_GET['accion'] === 'borrar' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id !== $_SESSION['user_id']) { // Evitar que un superusuario se elimine a sí mismo
        $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mensaje = "Usuario eliminado exitosamente.";
        } else {
            $mensaje = "Error al borrar el usuario.";
        }
        $stmt->close();
    } else {
        $mensaje = "No puedes borrarte a ti mismo.";
    }
}

// Manejar la modificación de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'modificar') {
    $id = intval($_POST['id']);
    $nuevo_username = trim($_POST['username']);
    $nuevo_rol = isset($_POST['is_superuser']) ? 1 : 0;

    $stmt = $db->prepare("UPDATE usuarios SET username = ?, is_superuser = ? WHERE id = ?");
    $stmt->bind_param("sii", $nuevo_username, $nuevo_rol, $id);

    if ($stmt->execute()) {
        $mensaje = "Usuario modificado exitosamente.";
    } else {
        $mensaje = "Error al modificar el usuario.";
    }
    $stmt->close();
}

// Obtener la lista de usuarios
$result = $db->query("SELECT id, username, is_superuser FROM usuarios");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1>Gestionar Usuarios</h1>

    <?php if (isset($mensaje)): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo $row['is_superuser'] ? 'Superusuario' : 'Usuario'; ?></td>
                <td>
                    <!-- Botón para borrar -->
                    <a href="?accion=borrar&id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?');">Borrar</a>
                    
                    <!-- Botón para mostrar el formulario de modificar -->
                    <a href="?accion=editar&id=<?php echo $row['id']; ?>">Modificar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Mostrar el formulario de modificar si se selecciona "Modificar" -->
    <?php if (isset($_GET['accion']) && $_GET['accion'] === 'editar' && isset($_GET['id'])):
        $id = intval($_GET['id']);
        $stmt = $db->prepare("SELECT username, is_superuser FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($username, $is_superuser);
        $stmt->fetch();
        $stmt->close();
    ?>
        <h2>Modificar Usuario</h2>
        <form method="post">
            <input type="hidden" name="accion" value="modificar">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="username">Nombre de usuario:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <br>
            <label for="is_superuser">Superusuario:</label>
            <input type="checkbox" name="is_superuser" <?php echo $is_superuser ? 'checked' : ''; ?>>
            <br>
            <button type="submit">Guardar cambios</button>
        </form>
    <?php endif; ?>

    <a href="dashboard.php">Regresar</a>
</body>
</html>
