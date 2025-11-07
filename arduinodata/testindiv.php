<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "plant_db"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT COUNT(*) as count FROM plot_a";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo json_encode(["status" => "empty"]);
} else {
    echo json_encode(["status" => "not_empty"]);
}

$conn->close();
?>