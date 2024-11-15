<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num_dados = intval($_POST['num_dados']);
    $caras_dado = intval($_POST['caras_dado']);
    $puntaje_contrincante = intval($_POST['puntaje_contrincante']);


    if ($num_dados < 1 || $num_dados > 3 || !in_array($caras_dado, [4, 6, 8, 10, 12, 20]) || $puntaje_contrincante < 1) {
        echo "Parámetros inválidos.";
        exit;
    }

  
    $resultado_dados = [];
    $suma_dados = 0;
    for ($i = 0; $i < $num_dados; $i++) {
        $lanzamiento = rand(1, $caras_dado);
        $resultado_dados[] = $lanzamiento;
        $suma_dados += $lanzamiento;
    }

    
    if ($suma_dados > $puntaje_contrincante) {
        $mensaje = "¡Ganaste!";
    } elseif ($suma_dados < $puntaje_contrincante) {
        $mensaje = "Perdiste.";
    } else {
        $mensaje = "Empate.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Juego</title>
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
        .result {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .dice-results {
            margin: 10px 0;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Resultado del Juego</h2>
        <div class="dice-results">
            <?php
            echo "Lanzamientos de dados: " . implode(", ", $resultado_dados) . "<br>";
            echo "Suma de los dados: " . $suma_dados . "<br>";
            echo "Puntaje del contrincante: " . $puntaje_contrincante . "<br>";
            ?>
        </div>
        <div class="result">
            <?php echo $mensaje; ?>
        </div>
        <br>
        <a href="da01.php">Jugar de Nuevo</a>
    </div>
</body>
</html>
