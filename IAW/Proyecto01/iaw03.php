<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_exception_handler(function($exception) {
    echo "Mi Excepción: " . $exception->getMessage();
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Lista sin enumerar</h2>
<ul>
        <?php
        $suma=0;
        for ($i = 0; $i < 4; $i++) {
            $numero = rand(1, 99);
            echo "<li>$numero</li>";
            $suma += $numero;
        }
      
    ?>
</ul>
<p style="background-color: blueviolet;">La suma de los números es: <span class="suma"><?php echo $suma; ?></span></p>
</body>
</html>