<?php
include 'includes/db_connect.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if username or email already exists
    $check = $conn->query("SELECT * FROM user WHERE username = '$username' OR email = '$email'");
    if ($check->num_rows > 0) {
        $message = "Username or email already taken.";
    } else {
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql)) {
            $message = "Registration successful. You can now log in.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

	<title>Register - PlantPal</title>
	<link rel="stylesheet" href="css/styles.css">
	
</head>
<body>
<h2>Register for PlantPal</h2>
<form method="post">
    Username: <input type="text" name="username" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Register">
</form>
<p><a href="index.php">Back to Login</a></p>
<?php if (!empty($message)) echo "<p style='color:blue;'>$message</p>"; ?>
</body>
</html>
