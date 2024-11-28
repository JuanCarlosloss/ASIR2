
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pitufos bonito bonitos</title>
</head>
<body>
    <h1>Pitufos bonito bonitos</h1>
    <ol type="I">
        <li>Nombre: <?php echo $_POST['nombre']; ?></li>
        <li>Apellidos: <?php echo $_POST['apellidos']; ?></li>
        <li>Edad: <?php echo $_POST['edad']; ?></li>
        <li>Nº de la suerte: <?php echo $_POST['numero_suerte']; ?></li>
    </ol>
    <form action="p4.php" method="post">
    <label hidden for="numero_suerte">Nº de la suerte (1-9):</label>
    <input hidden type="number" id="numero_suerte" name="numero_suerte" value="<?php echo $_POST['numero_suerte']?>" min="1" max="9" required>
    <button type="submit">Suerte</button>
    </form>
</body>
</html>