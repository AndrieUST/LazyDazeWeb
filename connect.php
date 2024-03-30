<?php
session_start(); // Move this line to the beginning of the file
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lazydaze";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
