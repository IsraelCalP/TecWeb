<?php


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Isra2818'); 
define('DB_NAME', 'marketzone');


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    // Es buena idea tener un mensaje de error aquí también
    die("Error de conexión: " . mysqli_connect_error());
}

?>