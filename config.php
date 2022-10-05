<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "loginsys";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die('Error: Cannot connect');
}

?>