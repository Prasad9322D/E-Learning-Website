<?php
// Database connection
$host = "localhost"; // Change if needed
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "secretCoder"; // Replace with your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $course = trim($_POST["course"]);

    // Validate inputs
    if (!empty($full_name) && !empty($email) && !empty($phone) && !empty($course)) {
        // Prepare and execute query
        $stmt = $conn->prepare("INSERT INTO enrollments (full_name, email, phone, course) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $email, $phone, $course);

        if ($stmt->execute()) {
            echo "<script>alert('Enrollment Successful!'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Error: Could not enroll.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
    }
}

$conn->close();
?>
