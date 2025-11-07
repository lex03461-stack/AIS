<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "plant_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize values from input fields
    $plant_name = htmlspecialchars($_POST['plant_name']);
    $plot = htmlspecialchars($_POST['plot']);
    $plant_type = htmlspecialchars($_POST['plant_type']);

    // Prepare and bind for the primary plants table
    $stmt = $conn->prepare("INSERT INTO plants (plant_name, plot, plant_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $plant_name, $plot, $plant_type);

    // Execute the statement for primary table
    if ($stmt->execute()) {
        // Prepare and bind for the specific plot table
        switch ($plot) {
            case 'A':
                $stmt2 = $conn->prepare("INSERT INTO plot_a (plant_name,plant_type) VALUES (?, ?)");
                break;
            case 'B':
                $stmt2 = $conn->prepare("INSERT INTO plot_b (plant_name,plant_type) VALUES (?, ?)");
                break;
            case 'C':
                $stmt2 = $conn->prepare("INSERT INTO plot_c (plant_name,plant_type) VALUES (?, ?)");
                break;
            case 'D':
                $stmt2 = $conn->prepare("INSERT INTO plot_d (plant_name,plant_type) VALUES (?, ?)");
                break;
            default:
                echo "Invalid plot selected.";
                exit;
        }

        // Bind the parameters for the secondary table
        $stmt2->bind_param("ss", $plant_name, $plant_type);

        // Execute the statement for secondary table
        if ($stmt2->execute()) {
            echo "New record created successfully in both plant name and type table.";
        } else {
            echo "Error in plot table: " . $stmt2->error;
        }

        // Close the secondary statement
        $stmt2->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the primary statement
    $stmt->close();
} else {
    echo "No data submitted.";
}

// Close the connection
$conn->close();
?>