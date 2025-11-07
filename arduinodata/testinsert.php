<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "sensor_data"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from Arduino
if (isset($_GET['soil_moisture']) && isset($_GET['likeliness'])) {
    $soilMoisture = intval($_GET['soil_moisture']);
    $likeliness = intval($_GET['likeliness']);

    // Insert data into the database
    $sql = "INSERT INTO readings (soil_moisture, likeliness) VALUES ($soilMoisture, $likeliness)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>