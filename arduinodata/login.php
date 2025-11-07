<?php
session_start();

$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "plant_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputId = $_POST['id']; // Changed from username to id
    $inputPassword = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?"); // Query by ID
    $stmt->bind_param("s", $inputId); // Bind as string
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($inputPassword, $hashedPassword)) {
            // Password is correct, start a session
            $_SESSION['id'] = $inputId; // Store ID in session
            header("Location: testdash.html"); // Redirect to a welcome page
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found.";
    }

    $stmt->close();
}

$conn->close();
$_SESSION['message'] = $message; // Store message in session
header("Location: login.html"); // Redirect back to login page
?>