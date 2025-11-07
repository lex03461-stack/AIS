<?php 

$hostname = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "plant_db"; 

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) 
{ 
	die("Connection failed: " . mysqli_connect_error()); 
} 

else {
echo "Database connection is OK. "; }

// If values send by Arduino/NodeMCU are not empty then insert into MySQL database table

if(!empty($_POST['sendval10']) && !empty($_POST['sendval11']) && !empty($_POST['sendval12']) )
{
	$temprature = $_POST['sendval10'];
	$moisture  = $_POST['sendval11'];
	$chance  = $_POST['sendval12'];
	


// Update your tablename here
	$sql = "INSERT INTO records(temperature, moisture, probability) VALUES (".$temprature.",".$moisture.",".$chance.")"; 

	if ($conn->query($sql) === TRUE) {
		echo "Values inserted in MySQL database table.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}


// Close MySQL connection
$conn->close();

?>