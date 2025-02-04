<?php
// Archivo: ranking.php
session_start();
include 'db.php';

// Validar que el usuario esté logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Obtener datos del ranking
$query = "
    SELECT u.username, r.puntos, r.fecha 
    FROM ranking r
    JOIN usuarios u ON r.usuario_id = u.id
    ORDER BY r.puntos ASC, r.fecha ASC
    LIMIT 10;
";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ranking</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1>Ranking de los mejores jugadores</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Intentos</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo $row['puntos']; ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php">Regresar al dashboard</a>
</body>
</html>
