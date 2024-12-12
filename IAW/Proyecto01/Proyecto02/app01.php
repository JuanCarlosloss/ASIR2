<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_exception_handler(function($exception) {
    echo "Mi Excepción: " . $exception->getMessage();
});
?>

<?php

require_once("dbutils.php");

$micon = conectarDB();

var_export(value: $micon);

$aPolvorones = realizarQuery($micon,"SELECT * FROM POLVORONES",argumentos: null,isfetch: true);

var_export($aPolvorones);

?>