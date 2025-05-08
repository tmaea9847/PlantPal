<?php
// Basic test to simulate saving a care reminder
include_once '../includes/db_connect.php';

$user_id = 1; // Update to match an actual user in your DB
$plant_id = 1; // Update to match an actual plant in your DB
$reminder_date = date("Y-m-d");
$task = "Water the plant";

$sql = "INSERT INTO reminders (user_id, plant_id, reminder_date, task) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $user_id, $plant_id, $reminder_date, $task);

if ($stmt->execute()) {
    echo "Reminder test passed.";
} else {
    echo "Reminder test failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
