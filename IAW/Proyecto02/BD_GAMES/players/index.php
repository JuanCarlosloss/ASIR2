<?php
require_once '../db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['update'])) {
           
            $id = $_POST['id'];
            $alias = $_POST['alias'];
            $sql = "UPDATE PLAYERS SET ALIAS = :alias WHERE ID = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':alias' => $alias, ':id' => $id]);
        } elseif (isset($_POST['delete'])) {
        
            $id = $_POST['id'];
            $sql = "DELETE FROM PLAYERS WHERE ID = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
        } elseif (isset($_POST['add'])) {
      
            $alias = $_POST['alias'];
            $sql = "INSERT INTO PLAYERS (ALIAS) VALUES (:alias)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':alias' => $alias]);
        }
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
}


try {
    $sql = "SELECT * FROM PLAYERS";
    $stmt = $pdo->query($sql);
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al recuperar jugadores: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Jugadores - Pac-Man Style</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <h1>👾 Gestión de Jugadores</h1>


    <table>
        <tr>
            <th>ID</th>
            <th>Alias</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($players as $player): ?>
            <tr>
                <td><?= htmlspecialchars($player['ID']) ?></td>
                <td><?= htmlspecialchars($player['ALIAS']) ?></td>
                <td>
              
                    <button onclick="editPlayer(<?= htmlspecialchars($player['ID']) ?>, '<?= htmlspecialchars($player['ALIAS']) ?>')">Editar</button>
             
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($player['ID']) ?>">
                        <button type="submit" name="delete" onclick="return confirm('¿Estás seguro de eliminar este jugador?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    
    <div id="form-container">
        <h2 id="form-title">Añadir Jugador</h2>
        <form method="POST">
            <input type="hidden" name="id" id="player-id">
            <label for="alias">Alias:</label>
            <input type="text" name="alias" id="player-alias" required>
            <button type="submit" name="add" id="form-submit">Guardar</button>
        </form>
    </div>
    
    <a href="../index.php">Volver al Inicio</a>
    <br><br>
    
    <script>
        function editPlayer(id, alias) {
           
            document.getElementById('form-title').textContent = 'Editar Jugador';
            document.getElementById('player-id').value = id;
            document.getElementById('player-alias').value = alias;
            document.getElementById('form-submit').name = 'update';
            document.getElementById('form-submit').textContent = 'Actualizar';
        }
    </script>
</body>
</html>
