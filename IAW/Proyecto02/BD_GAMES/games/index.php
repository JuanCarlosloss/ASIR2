<?php
require_once '../db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['update'])) {
  
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $sql = "UPDATE GAMES SET NOMBRE = :nombre WHERE ID = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre, ':id' => $id]);
        } elseif (isset($_POST['delete'])) {
      
            $id = $_POST['id'];
            $sql = "DELETE FROM GAMES WHERE ID = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
        } elseif (isset($_POST['add'])) {

            $nombre = $_POST['nombre'];
            $sql = "INSERT INTO GAMES (NOMBRE) VALUES (:nombre)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre]);
        }
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
}


try {
    $sql = "SELECT * FROM GAMES";
    $stmt = $pdo->query($sql);
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al recuperar los juegos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Juegos - Pac-Man Style</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <h1>👾 Gestión de Juegos</h1>


    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($games as $game): ?>
            <tr>
                <td><?= htmlspecialchars($game['ID']) ?></td>
                <td><?= htmlspecialchars($game['NOMBRE']) ?></td>
                <td>
         
                    <button onclick="editGame(<?= htmlspecialchars($game['ID']) ?>, '<?= htmlspecialchars($game['NOMBRE']) ?>')">Editar</button>
                
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($game['ID']) ?>">
                        <button type="submit" name="delete" onclick="return confirm('¿Estás seguro de eliminar este juego?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div id="form-container">
        <h2 id="form-title">Añadir Juego</h2>
        <form method="POST">
            <input type="hidden" name="id" id="game-id">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="game-nombre" required>
            <button type="submit" name="add" id="form-submit">Guardar</button>
        </form>
    </div>
    
    <a href="../index.php">Volver al Inicio</a>
    <br><br>
    <script>
        function editGame(id, nombre) {

            document.getElementById('form-title').textContent = 'Editar Juego';
            document.getElementById('game-id').value = id;
            document.getElementById('game-nombre').value = nombre;
            document.getElementById('form-submit').name = 'update';
            document.getElementById('form-submit').textContent = 'Actualizar';
        }
    </script>
</body>
</html>
