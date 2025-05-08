<?php
include '../includes/db_connect.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode([]);
    exit();
}

$username = $conn->real_escape_string($_SESSION['username']);
$userQuery = $conn->query("SELECT user_id FROM user WHERE username = '$username'");
$user = $userQuery->fetch_assoc();
$user_id = $user['user_id'];

$result = $conn->query("SELECT content, created_at FROM notes WHERE user_id = $user_id ORDER BY created_at DESC");
$notes = [];

while ($row = $result->fetch_assoc()) {
    $notes[] = $row;
}

echo json_encode($notes);
