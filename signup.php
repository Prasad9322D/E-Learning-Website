<?php
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

    $username = $conn->real_escape_string($_POST["username"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hashing password

    // Check if email already exists
    $checkEmail = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "<script>alert('Error: Email already registered!'); window.location.href='signup.html';</script>";
    } else {
        // Insert into database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Signup Successful! Please login.'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Error: Could not register.'); window.location.href='signup.html';</script>";
        }
    }
}

// Close connection
$conn->close();
?>
