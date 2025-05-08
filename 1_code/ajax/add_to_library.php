<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    echo "You must be logged in.";
    exit();
}

// Get user_id from session
$username = $_SESSION['username'];
$userQuery = $conn->query("SELECT user_id FROM user WHERE username = '$username'");
$user = $userQuery->fetch_assoc();
$user_id = $user['user_id'];

$plant_id = intval($_POST['plant_id']);

$check = $conn->query("SELECT * FROM user_library WHERE user_id = $user_id AND plant_id = $plant_id");
if ($check->num_rows === 0) {
    $insert = $conn->query("INSERT INTO user_library (user_id, plant_id) VALUES ($user_id, $plant_id)");
    echo "Added to your library!";
} else {
    echo "This plant is already in your library.";
}
?>
