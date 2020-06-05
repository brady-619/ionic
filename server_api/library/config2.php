<?php


//define('DB_NAME', 'planificador_dish'); // DATABASE
define('DB_NAME2', 'delivery_dish'); 
define('DB_USER2', 'octopus'); // ROOT DEFAULT MYSQL
define('DB_PASSWORD2', 'OcT0#D1sH#2020');  // PASSOWORD
define('DB_HOST2', '172.20.152.21:3306'); // LOCAL IF YOU USE LOCAL.

$mysqli2 = new mysqli(DB_HOST2, DB_USER2, DB_PASSWORD2, DB_NAME2);

?>