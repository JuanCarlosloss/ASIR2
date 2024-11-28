
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pitufo bonito bonitos</title>
</head>
<body>
    <h1>Pitufo bonito bonitos</h1>
    <form action="p3.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $_POST['nombre']; ?>" readonly><br>
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo $_POST['apellidos']; ?>" readonly><br>
        
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required><br>
        
        <label for="numero_suerte">Nº de la suerte (1-9):</label>
        <input type="number" id="numero_suerte" name="numero_suerte" min="1" max="9" required><br>
        
        <img src="../EXA_IAW1/img/img<?php echo rand(1, 4); ?>.png" alt="Imagen Aleatoria" style="width: 10%;display:block; margin:auto;"><br>
        <button type="submit">Continuar</button>
    </form>
</body>
</html>
