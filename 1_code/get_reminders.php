<?php
include '../includes/db_connect.php';
session_start();

header('Content-Type: application/json');

// Check login
if (!isset($_SESSION['username'])) {
    echo json_encode([]);
    exit();
}

$username = $conn->real_escape_string($_SESSION['username']);

// Get user ID
$userQuery = $conn->query("SELECT user_id FROM user WHERE username = '$username'");
if (!$userQuery || $userQuery->num_rows === 0) {
    echo json_encode([]);
    exit();
}
$user_id = $userQuery->fetch_assoc()['user_id'];

// Fetch reminders for this user
$reminders = [];
$sql = "
    SELECT r.id, r.reminder_type, r.next_due_date, p.name AS plant_name
    FROM reminders r
    JOIN plants p ON r.plant_id = p.id
    WHERE r.plant_id IN (
        SELECT plant_id FROM user_library WHERE user_id = $user_id
    )
";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reminders[] = [
            "id" => $row['id'],
            "title" => "{$row['reminder_type']} – {$row['plant_name']}",
            "start" => $row['next_due_date']
        ];
    }
}

echo json_encode($reminders);
?>
