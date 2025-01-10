<?php
require_once '../db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['update'])) {
            
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $id_game = $_POST['id_game'];
            $id_player1 = $_POST['id_player1'];
            $id_player2 = $_POST['id_player2'];
            $sql = "UPDATE PARTIDAS SET NOMBRE = :nombre, ID_GAME = :id_game, ID_PLAYER1 = :id_player1, ID_PLAYER2 = :id_player2 WHERE ID = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre, ':id_game' => $id_game, ':id_player1' => $id_player1, ':id_player2' => $id_player2, ':id' => $id]);
        } elseif (isset($_POST['delete'])) {
            
            $id = $_POST['id'];
            $sql = "DELETE FROM PARTIDAS WHERE ID = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
        } elseif (isset($_POST['add'])) {

            $nombre = $_POST['nombre'];
            $id_game = $_POST['id_game'];
            $id_player1 = $_POST['id_player1'];
            $id_player2 = $_POST['id_player2'];
            $sql = "INSERT INTO PARTIDAS (NOMBRE, ID_GAME, ID_PLAYER1, ID_PLAYER2) VALUES (:nombre, :id_game, :id_player1, :id_player2)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre, ':id_game' => $id_game, ':id_player1' => $id_player1, ':id_player2' => $id_player2]);
        }
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
}


try {
    $sql = "SELECT PARTIDAS.*, GAMES.NOMBRE AS GAME_NAME, P1.ALIAS AS PLAYER1_NAME, P2.ALIAS AS PLAYER2_NAME
            FROM PARTIDAS
            JOIN GAMES ON PARTIDAS.ID_GAME = GAMES.ID
            JOIN PLAYERS P1 ON PARTIDAS.ID_PLAYER1 = P1.ID
            JOIN PLAYERS P2 ON PARTIDAS.ID_PLAYER2 = P2.ID";
    $stmt = $pdo->query($sql);
    $partidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al recuperar partidas: " . $e->getMessage());
}


try {
    $games = $pdo->query("SELECT * FROM GAMES")->fetchAll(PDO::FETCH_ASSOC);
    $players = $pdo->query("SELECT * FROM PLAYERS")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al recuperar datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Partidas - Pac-Man Style</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <h1>👾 Gestión de Partidas</h1>

 
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Juego</th>
            <th>Jugador 1</th>
            <th>Jugador 2</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($partidas as $partida): ?>
            <tr>
                <td><?= htmlspecialchars($partida['ID']) ?></td>
                <td><?= htmlspecialchars($partida['NOMBRE']) ?></td>
                <td><?= htmlspecialchars($partida['GAME_NAME']) ?></td>
                <td><?= htmlspecialchars($partida['PLAYER1_NAME']) ?></td>
                <td><?= htmlspecialchars($partida['PLAYER2_NAME']) ?></td>
                <td>
                
                    <button onclick="editPartida(
                        <?= htmlspecialchars($partida['ID']) ?>, 
                        '<?= htmlspecialchars($partida['NOMBRE']) ?>', 
                        <?= htmlspecialchars($partida['ID_GAME']) ?>, 
                        <?= htmlspecialchars($partida['ID_PLAYER1']) ?>, 
                        <?= htmlspecialchars($partida['ID_PLAYER2']) ?>)">Editar</button>
          
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($partida['ID']) ?>">
                        <button type="submit" name="delete" onclick="return confirm('¿Estás seguro de eliminar esta partida?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div id="form-container">
        <h2 id="form-title">Añadir Partida</h2>
        <form method="POST">
            <input type="hidden" name="id" id="partida-id">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="partida-nombre" required>

            <label for="id_game">Juego:</label>
            <select name="id_game" id="partida-id-game" required>
                <?php foreach ($games as $game): ?>
                    <option value="<?= htmlspecialchars($game['ID']) ?>"><?= htmlspecialchars($game['NOMBRE']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="id_player1">Jugador 1:</label>
            <select name="id_player1" id="partida-id-player1" required>
                <?php foreach ($players as $player): ?>
                    <option value="<?= htmlspecialchars($player['ID']) ?>"><?= htmlspecialchars($player['ALIAS']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="id_player2">Jugador 2:</label>
            <select name="id_player2" id="partida-id-player2" required>
                <?php foreach ($players as $player): ?>
                    <option value="<?= htmlspecialchars($player['ID']) ?>"><?= htmlspecialchars($player['ALIAS']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="add" id="form-submit">Guardar</button>
        </form>
    </div>

    <a href="../index.php">Volver al Inicio</a>

    <script>
        function editPartida(id, nombre, idGame, idPlayer1, idPlayer2) {
          
            document.getElementById('form-title').textContent = 'Editar Partida';
            document.getElementById('partida-id').value = id;
            document.getElementById('partida-nombre').value = nombre;
            document.getElementById('partida-id-game').value = idGame;
            document.getElementById('partida-id-player1').value = idPlayer1;
            document.getElementById('partida-id-player2').value = idPlayer2;
            document.getElementById('form-submit').name = 'update';
            document.getElementById('form-submit').textContent = 'Actualizar';
        }
    </script>
</body>
</html>
