<?php
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

// Pagination parameters
$recordsPerPage = 10; // Number of records to display per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page or default to 1

// Calculate total records
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM records");
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Calculate the starting record for the SQL query
$startFrom = ($currentPage - 1) * $recordsPerPage;

// Fetch data for the current page
$sql = "SELECT temperature, moisture, probability, collected FROM records LIMIT $startFrom, $recordsPerPage";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row; // Store each row in the data array
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode(array('data' => $data, 'totalPages' => $totalPages, 'currentPage' => $currentPage));

$conn->close();
?>