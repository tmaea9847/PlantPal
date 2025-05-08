<?php
// Basic test to simulate user registration
include_once '../includes/db_connect.php';

$username = "testuser";
$email = "testuser@example.com";
$password_hash = password_hash("TestPass123", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) {
    echo "User registration test passed.";
} else {
    echo "User registration test failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
