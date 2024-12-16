<?php
$numero_suerte = $_POST['numero_suerte'];
$premio = 100 * $numero_suerte * rand(1, 5);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pitufo bonito bonitos</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 25px;
            text-align: center;
            margin: 0;
        }
        .premio {
            font-size: 50px;
            color: #ff0000; 
        }
        .mensaje {
            font-size: 2em;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div>
        <h1>Pitufos bonito bonitos Premio</h1>
        <p class="premio"><?php echo $premio; ?></p>
        <?php if ($premio > 3000): ?>
            <p class="mensaje">Enhorabuena de la buena</p>
        <?php endif; ?>
        <form action="p4.php" method="post">
        <label hidden for="numero_suerte">Nº de la suerte (1-9):</label>
        <input hidden type="number" id="numero_suerte" name="numero_suerte" value="<?php echo $_POST['numero_suerte']?>" min="1" max="9" required>
            <button type="submit">Probar suerte de nuevo</button>
        </form>
    </div>
</body>
</html>