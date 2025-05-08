<?php
include '../includes/db_connect.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$username = $conn->real_escape_string($_SESSION['username']);
$userResult = $conn->query("SELECT user_id FROM user WHERE username = '$username'");

if (!$userResult || $userResult->num_rows === 0) {
    echo json_encode(['error' => 'User not found']);
    exit();
}

$user_id = $userResult->fetch_assoc()['user_id'];

// Total number of plants in user's library
$plantCount = 0;
$plantCountResult = $conn->query("
    SELECT COUNT(*) AS total 
    FROM user_library 
    WHERE user_id = $user_id
");
if ($plantCountResult && $row = $plantCountResult->fetch_assoc()) {
    $plantCount = $row['total'];
}

// Last added plant
$lastPlant = 'None';
$lastPlantResult = $conn->query("
    SELECT p.name 
    FROM user_library ul
    JOIN plants p ON ul.plant_id = p.id
    WHERE ul.user_id = $user_id
    ORDER BY ul.id DESC
    LIMIT 1
");
if ($lastPlantResult && $row = $lastPlantResult->fetch_assoc()) {
    $lastPlant = $row['name'];
}

// Most recent 3 notes
$notes = [];
$notesResult = $conn->query("
    SELECT content 
    FROM notes 
    WHERE user_id = $user_id 
    ORDER BY created_at DESC 
    LIMIT 3
");
while ($row = $notesResult->fetch_assoc()) {
    $notes[] = $row['content'];
}

// Upcoming care tasks
$calendar = [];
$calendarResult = $conn->query("
    SELECT r.reminder_type, r.next_due_date, p.name
    FROM reminders r
    JOIN plants p ON r.plant_id = p.id
    WHERE r.plant_id IN (
        SELECT plant_id FROM user_library WHERE user_id = $user_id
    )
    ORDER BY r.next_due_date ASC
    LIMIT 5
");
while ($row = $calendarResult->fetch_assoc()) {
    $calendar[] = [
        'task' => "{$row['reminder_type']} – {$row['name']}",
        'date' => $row['next_due_date']
    ];
}

// Output JSON
echo json_encode([
    'total_plants' => $plantCount,
    'last_added' => $lastPlant,
    'notes' => $notes,
    'calendar' => $calendar
]);
?>
