<?php
include '../includes/db_connect.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$note = trim($_POST['note'] ?? '');
if ($note === '') {
    echo json_encode(['error' => 'Note cannot be empty']);
    exit();
}

$username = $conn->real_escape_string($_SESSION['username']);
$userQuery = $conn->query("SELECT user_id FROM user WHERE username = '$username'");
$user = $userQuery->fetch_assoc();
$user_id = $user['user_id'];

$stmt = $conn->prepare("INSERT INTO notes (user_id, content, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("is", $user_id, $note);
$stmt->execute();

echo json_encode(['success' => true]);
