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
    <style>
        .summary-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px auto; /* Centrar el cuadro */
            width: 50%;
            text-align: center;
        }
        .summary-box ul {
            list-style-type: none;
            padding: 0;
        }
        .summary-box ul li {
            margin: 10px 0;
        }

    </style>
</head>
<body>
    <h1 style="text-align: center;">Gesti&oacute;n de BD_GAMES</h1>
    <div class="button-container">
        <button onclick="window.location.href='players/index.php'">Gestionar PLAYERS</button>
        <button onclick="window.location.href='games/index.php'">Gestionar GAMES</button>
        <button onclick="window.location.href='partidas/index.php'">Gestionar PARTIDAS</button>
    </div>
    <h2 style="text-align: center;">Resumen de Control</h2>
    <div class="summary-box">
        <ul>
            <li>Total de jugadores: <?= $totalPlayers ?></li>
            <li>Total de juegos: <?= $totalGames ?></li>
            <li>Total de partidas: <?= $totalPartidas ?></li>
            <li>Jugadores en 2 partidas: <?= $playersIn2Partidas ?></li>
            <li>Jugadores en 3 partidas: <?= $playersIn3Partidas ?></li>
            <li>Jugadores en m&aacute;s de 3 partidas: <?= $playersInMore3Partidas ?></li>
        </ul>
    </div>
</body>
</html>