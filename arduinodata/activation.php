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

// Handle deletion of values
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_values'])) {
    $tableToModify = $_POST['table'];
    $deleteSql = "DELETE FROM $tableToModify";
    $conn->query($deleteSql);
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

    <!-- Form to delete values -->
    <form method="POST">
        <input type="hidden" name="table" value="<?= $table ?>">
        <button type="submit" name="delete_values">Delete All Values</button>
    </form>
<?php endforeach; ?>

</body>
</html>