<?php
$host ="";
$user = "";
$password = "";
$database = "";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}

?>