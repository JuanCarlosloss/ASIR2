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
<?php


$num1 = rand(min:1,max:99);
$num2 = rand(min:1,max:99);
$num3 = rand(min:1,max:99);
$num4 = rand(min:1,max:99);
$suma = $num1+$num2+$num3+$num4;
?>
<ul>
    <li><?php echo $num1 ?></li>
    <li><?php echo $num2 ?></li>
    <li><?php echo $num3 ?></li>
    <li><?php echo $num4 ?></li>
</ul>

<h2 style="background-color: greenyellow;"> <?php
echo "la suma de los numeros es: ".$suma;
$media = $suma/4;
echo "La media es: ".$media;
?>
</h2>
</body>

</html>