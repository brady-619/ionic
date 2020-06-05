<?php


//define('DB_NAME', 'planificador_dish'); // DATABASE
define('DB_NAME', 'planificador_dish'); 
define('DB_USER', 'octopus'); // ROOT DEFAULT MYSQL
define('DB_PASSWORD', 'OcT0#D1sH#2020');  // PASSOWORD
define('DB_HOST', '172.20.152.21:3306'); // LOCAL IF YOU USE LOCAL.

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>