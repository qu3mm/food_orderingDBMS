<?php

$servername =  getenv('servername');;
$username = getenv('username');;
$password = getenv('password');;
$database = getenv('database');;

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("". $conn->connect_error);
}

?>