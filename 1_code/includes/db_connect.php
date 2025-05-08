<?php
$host = 'localhost';
$db   = 'plant_db';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
