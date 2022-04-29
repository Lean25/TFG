
<?php

    @session_start();

    $host_mysql = "127.0.0.1";
    $user_mysql = "root";
    $pass_mysql = "";
    $db_mysql = "tiendadeporte";

    $con = mysqli_connect($host_mysql, $user_mysql, $pass_mysql)  or die("Error al conectar al servidor de la BBDD");
    mysqli_select_db($con, $db_mysql) or die("Error al conectar a la base de datos");


define('USER', 'root');
define('PASSWORD', '');
define('HOST', '127.0.0.1');
define('DATABASE', 'tiendadeporte');

try {
    $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

?>