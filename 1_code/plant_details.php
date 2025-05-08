<?php
include 'includes/db_connect.php';
include 'includes/session.php';

if (!isset($_GET['id'])) {
    echo "Plant not specified.";
    exit;
}

$plantId = intval($_GET['id']);
$result = $conn->query("SELECT * FROM plants WHERE id = $plantId");

if ($result->num_rows === 0) {
    echo "Plant not found.";
    exit;
}

$plant = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($plant['name']); ?> - Details</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .details-container {
            max-width: 800px;
            margin: 40px auto;
            background: #f8fdfc;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .details-container img {
            max-width: 200px;
            float: right;
            margin-left: 20px;
            border-radius: 12px;
        }
        .details-container h1 {
            margin-top: 0;
        }
        .details-container ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>

<div class="details-container">
    <img src="images/<?php echo htmlspecialchars($plant['image_url']); ?>" alt="<?php echo htmlspecialchars($plant['name']); ?>">
    <h1><?php echo htmlspecialchars($plant['name']); ?></h1>
    <h4><em><?php echo htmlspecialchars($plant['scientificName']); ?></em></h4>

    <ul>
        <li><strong>Origin:</strong> <?php echo htmlspecialchars($plant['origin']); ?></li>
        <li><strong>Family:</strong> <?php echo htmlspecialchars($plant['plantFamily']); ?></li>
        <li><strong>Care Difficulty:</strong> <?php echo htmlspecialchars($plant['careDifficulty']); ?></li>
        <li><strong>Propagation:</strong> <?php echo htmlspecialchars($plant['propagation']); ?></li>
        <li><strong>Watering Schedule:</strong> <?php echo htmlspecialchars($plant['wateringSchedule']); ?></li>
        <li><strong>Light Requirements:</strong> <?php echo htmlspecialchars($plant['lightRequirements']); ?></li>
        <li><strong>Soil Type:</strong> <?php echo htmlspecialchars($plant['soilType']); ?></li>
    </ul>

    <p><a href="dashboard.php" style="color:#2c5f4a;">← Back to Dashboard</a></p>
</div>

</body>
</html>
