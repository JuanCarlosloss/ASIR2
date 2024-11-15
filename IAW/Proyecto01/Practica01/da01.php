<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Juego de Dados</h2>
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

            <button type="submit">Jugar</button>
        </form>
    </div>
</body>
</html>
