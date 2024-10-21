<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h2 style="background-color: <?php 
   
    if(rand(min: 0, max: 1) == 0)
    {
        echo 'red';
    }
    else
    {
        echo 'green';
    }
    ?>
    
    ;"><?PHP echo 'HOLA MUNDO' ?></h2>
</body>
</html>