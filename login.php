<?php
session_start(); // Start session

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            // Set session variables
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];

            echo "<script>alert('Login Successful!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid Password!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found! Please Signup.'); window.location.href='signup.html';</script>";
    }
}

$conn->close();
?>
