<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $num_dados = intval($_POST['num_dados']);
    $caras_dado = intval($_POST['caras_dado']);
    $puntaje_contrincante = intval($_POST['puntaje_contrincante']);

    
    $max_puntaje_posible = $num_dados * $caras_dado;

    if ($num_dados < 1 || $num_dados > 3 || 
        !in_array($caras_dado, [4, 6, 8, 10, 12, 20]) || 
        $puntaje_contrincante < 1 || 
        $puntaje_contrincante > $max_puntaje_posible) {
        echo "<p>Parámetros inválidos: 
                <br>- Número de dados debe estar entre 1 y 3.
                <br>- Caras de los dados debe ser 4, 6, 8, 10, 12 o 20.
                <br>- Puntaje del contrincante debe ser menor o igual al máximo puntaje posible: $max_puntaje_posible.</p>";
        exit;
    }

    
    $resultado_dados = [];
    for ($i = 0; $i < $num_dados; $i++) {
        $resultado_dados[] = rand(1, $caras_dado);
    }

    
    $suma_dados = array_sum($resultado_dados);

    
    if ($suma_dados > $puntaje_contrincante) {
        $mensaje = "¡Ganaste!";
        $resultado_clase = "win";
    } elseif ($suma_dados < $puntaje_contrincante) {
        $mensaje = "Perdiste.";
        $resultado_clase = "lose";
    } else {
        $mensaje = "Empate.";
        $resultado_clase = "draw";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Juego</title>
    <link rel="stylesheet" href="styles_da02.css">
    <script src="scripts_da02.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="title">Resultado del Juego</h1>
        <div class="dice-animation">
            <?php for ($i = 0; $i < $num_dados; $i++): ?>
                <div class="dice" id="dice-<?php echo $i; ?>">
                    <span>🎲</span>
                </div>
            <?php endfor; ?>
        </div>
        <div class="result-container" id="result" style="display: none;">
            <p>Lanzamientos de dados: <?php echo implode(", ", $resultado_dados); ?></p>
            <p>Suma de los dados: <?php echo $suma_dados; ?></p>
            <p>Puntaje del contrincante: <?php echo $puntaje_contrincante; ?></p>
            <h2 class="<?php echo $resultado_clase; ?>"><?php echo $mensaje; ?></h2>
            <p><strong>Puntaje máximo posible:</strong> <?php echo $max_puntaje_posible; ?></p>
        </div>
        <button onclick="window.location.href='da01.php'">Jugar de Nuevo</button>
    </div>
</body>
</html>
