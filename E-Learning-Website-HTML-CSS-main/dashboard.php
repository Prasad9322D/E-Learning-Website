<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "secretCoder";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_id = $_SESSION["user_id"];
$sql = "SELECT username, email FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found!'); window.location.href='login.html';</script>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user["username"]); ?>!</h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
        
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
