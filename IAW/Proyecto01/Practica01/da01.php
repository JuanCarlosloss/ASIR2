<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Dados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="title">🎲 Juego de Dados 🎲</h1>
        <form action="da02.php" method="POST">
            <label for="num_dados">Cantidad de Dados (1-3):</label>
            <input type="number" id="num_dados" name="num_dados" min="1" max="3" required>

            <label for="caras_dado">Caras del Dado:</label>
            <select id="caras_dado" name="caras_dado" required>
                <option value="4">4</option>
                <option value="6">6</option>
                <option value="8">8</option>
                <option value="10">10</option>
                <option value="12">12</option>
                <option value="20">20</option>
            </select>

            <label for="puntaje_contrincante">Puntaje del Contrincante:</label>
            <input type="number" id="puntaje_contrincante" name="puntaje_contrincante" min="1" required>

            <button type="submit">¡Jugar!</button>
        </form>
    </div>
</body>
</html>
