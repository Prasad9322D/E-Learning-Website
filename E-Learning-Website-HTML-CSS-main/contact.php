<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "secretCoder";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if all form fields are set and not empty
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["subject"]) && !empty($_POST["message"])) {

        // Retrieve form values and escape special characters
        $name = $conn->real_escape_string($_POST["name"]);
        $email = $conn->real_escape_string($_POST["email"]);
        $subject = $conn->real_escape_string($_POST["subject"]);
        $message = $conn->real_escape_string($_POST["message"]);

        // Check if email already exists
        $checkEmail = "SELECT id FROM contacts WHERE email = '$email' LIMIT 1";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            echo "<script>
                    alert('Error: This email is already registered!');
                    window.location.href = 'contact.html';
                  </script>";
            exit();
        } else {
            // Insert into database
            $sql = "INSERT INTO contacts (name, email, subject, message, created_at) 
                    VALUES ('$name', '$email', '$subject', '$message', NOW())";

            if ($conn->query($sql) === TRUE) {
                echo "<script>
                        alert('Your message has been sent successfully!');
                        window.location.href = 'contact.html';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Error: Unable to send message!');
                        window.location.href = 'contact.html';
                      </script>";
                exit();
            }
        }
    } else {
        echo "<script>
                alert('Error: All fields are required!');
                window.location.href = 'contact.html';
              </script>";
        exit();
    }
} else {
    echo "<script>
            window.location.href='http://localhost:8080/project/E-Learning-Website-HTML-CSS-main/E-Learning-Website-HTML-CSS-main/contact.html';
          </script>";
    exit();
}

// Close connection
$conn->close();
?>
