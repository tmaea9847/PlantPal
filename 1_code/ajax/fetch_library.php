<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    echo "You must be logged in.";
    exit();
}

// Get user_id from session
$username = $conn->real_escape_string($_SESSION['username']);
$userQuery = $conn->query("SELECT user_id FROM user WHERE username = '$username'");
$user = $userQuery->fetch_assoc();
$user_id = $user['user_id'];

$sql = "SELECT p.* FROM plants p
        JOIN user_library ul ON p.id = ul.plant_id
        WHERE ul.user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border:1px solid #ccc; margin-bottom:10px; padding:10px; display:flex; align-items:center; background-color:#f8fcfb;'>";

        echo "<img src='images/" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "' style='width:80px; height:auto; margin-right:15px;'>";

        echo "<div>";
        echo "<a href='plant_details.php?id=" . $row['id'] . "'><strong>" . htmlspecialchars($row['name']) . "</strong></a> ";
        echo "(" . htmlspecialchars($row['plantFamily']) . ")<br>";
        echo "Light: " . htmlspecialchars($row['lightRequirements']) . "<br>";
        echo "Water: " . htmlspecialchars($row['wateringSchedule']);
        echo "</div>";

        echo "</div>";
    }
} else {
    echo "<p>You haven't added any plants yet.</p>";
}
?>
