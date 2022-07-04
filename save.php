<?php

//insert.php

$connect = new PDO("mysql:host=localhost;dbname=php_timer", "root", "");

// $conn = mysqli_connect("localhost", "root", "", "php_timer") or die(mysqli_error());
//     	if(!$conn){
//     		die("Error: Failed to connect to database");
//     	}

$query = "
INSERT INTO timer 
(name, time) 
VALUES (:name, :time)
";

for($count = 0; $count<count($_POST['hidden_name']); $count++)
{
	$data = array(
		':name'	=>	$_POST['hidden_name'][$count],
		':time'	=>	$_POST['hidden_time'][$count]
	);
	$statement = $connect->prepare($query);
	$statement->execute($data);
}

?>