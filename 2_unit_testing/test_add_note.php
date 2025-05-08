<?php
// Basic test to simulate adding a note
include_once '../includes/db_connect.php';

$user_id = 1; // Update to match an actual user in your DB
$plant_id = 1; // Update to match an actual plant in your DB
$content = "This is a test note.";

$sql = "INSERT INTO notes (user_id, plant_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $user_id, $plant_id, $content);

if ($stmt->execute()) {
    echo "Note addition test passed.";
} else {
    echo "Note addition test failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
