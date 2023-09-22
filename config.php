<?php

$server = "localhost";
$user = "root";
$pass = "";
$database = "shopee";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>