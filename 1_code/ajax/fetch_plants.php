<?php
include '../includes/db_connect.php';

$search = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

$sql = "SELECT * FROM plants WHERE name LIKE '%$search%' OR plantFamily LIKE '%$search%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border-bottom:1px solid #ccc; padding:10px;'>";

        echo "<img src='images/" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "' class='plant-img'>";

        // Plant name as a clickable link
        echo "<a href='plant_details.php?id=" . $row['id'] . "'><strong>" . htmlspecialchars($row['name']) . "</strong></a> (" . htmlspecialchars($row['plantFamily']) . ")<br>";

        echo "Light: " . htmlspecialchars($row['lightRequirements']) . "<br>";
        echo "Water: " . htmlspecialchars($row['wateringSchedule']) . "<br>";

        // Add to library form
        echo "<form method='post' onsubmit='addToLibrary(event, {$row['id']})'>";
        echo "<button type='submit'>Add to My Library</button>";
        echo "</form>";

        echo "</div>";
    }
} else {
    echo "<p>No matching plants found.</p>";
}
?>
