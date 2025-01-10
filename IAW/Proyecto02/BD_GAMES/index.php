<?php
include 'db.php';


$totalPlayers = $pdo->query("SELECT COUNT(*) FROM PLAYERS")->fetchColumn();
$totalGames = $pdo->query("SELECT COUNT(*) FROM GAMES")->fetchColumn();
$totalPartidas = $pdo->query("SELECT COUNT(*) FROM PARTIDAS")->fetchColumn();

$playersIn2Partidas = $pdo->query("SELECT COUNT(*) FROM PLAYERS WHERE ID IN (SELECT ID_PLAYER1 FROM PARTIDAS GROUP BY ID_PLAYER1 HAVING COUNT(ID_PLAYER1) = 2)")->fetchColumn();
$playersIn3Partidas = $pdo->query("SELECT COUNT(*) FROM PLAYERS WHERE ID IN (SELECT ID_PLAYER1 FROM PARTIDAS GROUP BY ID_PLAYER1 HAVING COUNT(ID_PLAYER1) = 3)")->fetchColumn();
$playersInMore3Partidas = $pdo->query("SELECT COUNT(*) FROM PLAYERS WHERE ID IN (SELECT ID_PLAYER1 FROM PARTIDAS GROUP BY ID_PLAYER1 HAVING COUNT(ID_PLAYER1) > 3)")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Gestión de BD_GAMES</h1>
    <nav>
        <a href="players/index.php">Gestionar PLAYERS</a>
        <a href="games/index.php">Gestionar GAMES</a>
        <a href="partidas/index.php">Gestionar PARTIDAS</a>
    </nav>
    <h2>Resumen de Control</h2>
    <ul>
        <li>Total de jugadores: <?= $totalPlayers ?></li>
        <li>Total de juegos: <?= $totalGames ?></li>
        <li>Total de partidas: <?= $totalPartidas ?></li>
        <li>Jugadores en 2 partidas: <?= $playersIn2Partidas ?></li>
        <li>Jugadores en 3 partidas: <?= $playersIn3Partidas ?></li>
        <li>Jugadores en más de 3 partidas: <?= $playersInMore3Partidas ?></li>
    </ul>
</body>
</html>
