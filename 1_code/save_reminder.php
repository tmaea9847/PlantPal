<?php
include '../includes/db_connect.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$username = $conn->real_escape_string($_SESSION['username']);
$userQuery = $conn->query("SELECT user_id FROM user WHERE username = '$username'");
if (!$userQuery || $userQuery->num_rows === 0) {
    echo json_encode(['error' => 'User not found']);
    exit();
}

$user_id = $userQuery->fetch_assoc()['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title'] ?? '');
    $date = $conn->real_escape_string($_POST['date'] ?? '');
    $plant_id = isset($_POST['plant_id']) ? (int)$_POST['plant_id'] : null; // optional plant association

    if (empty($title) || empty($date)) {
        echo json_encode(['error' => 'Title and date are required.']);
        exit();
    }

    $query = "INSERT INTO reminders (user_id, reminder_type, next_due_date, plant_id) 
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issi", $user_id, $title, $date, $plant_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to save reminder.']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
