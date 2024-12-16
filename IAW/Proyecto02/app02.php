<?php

require_once("dbutils.php");

$micon = conectarDB();

#var_export(value: $micon);

$aPolvorones = realizarQuery($micon,"SELECT * FROM POLVORONES",null,true);
$aPolvoronesa = realizarQuery($micon,"SELECT * FROM POLVORONES WHERE COLOR_ENVOLTORIO = 'AMARILLO'",null,true);
#var_export($aPolvorones);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container mt-3">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>SABOR</th>
        <th>FECHA_CADUCIDAD</th>
        <th>COLOR_ENVOLTORIO</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($aPolvorones as $polvoronI) 
        {
            echo "<tr>";
            echo "<td>".$polvoronI['SABOR']."</td>";
            echo "<td>".$polvoronI['FECHA_CADUCIDAD']."</td>";
            echo "<td>".$polvoronI['COLOR_ENVOLTORIO']."</td>";
            echo "</tr>";


        };
      ?>

      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
    <div class="container mt-3">
    <table class="table table-striped">
    <tbody>
    <thead>
      <tr>
        <th>SABOR</th>
        <th>FECHA_CADUCIDAD</th>
        <th>COLOR_ENVOLTORIO</th>
      </tr>
    </thead>
    <?php
        foreach ($aPolvoronesa as $polvoronII) 
        {
            echo "<tr>";
            echo "<td>".$polvoronII['SABOR']."</td>";
            echo "<td>".$polvoronII['FECHA_CADUCIDAD']."</td>";
            echo "<td>".$polvoronII['COLOR_ENVOLTORIO']."</td>";
            echo "</tr>";


        };
      ?>
    </tbody>
  </table>
    </div>
</div>
</body>
</html>