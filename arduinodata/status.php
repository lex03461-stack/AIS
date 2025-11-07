<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plant_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of table names to check
$tables = ['plot_a', 'plot_b', 'plot_c', 'plot_d'];
$statuses = [];

// Check each table
foreach ($tables as $table) {
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $statuses[$table] = $result->num_rows > 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Status Check</title>
    <style>
        .active {
            color: green;
        }
        .inactive {
            color: red;
        }
    </style>
</head>
<body>

<h1>Database Table Status</h1>

<?php foreach ($statuses as $table => $isActive): ?>
    <p class="<?= $isActive ? 'active' : 'inactive' ?>">
        <?= ucfirst($table) ?>: <?= $isActive ? 'Active' : 'Deactivated' ?>
    </p>
<?php endforeach; ?>

</body>
</html>