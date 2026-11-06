<?php
$hostname = "localhost" ;
$username = "root";
$password = "";
//untuk mengkoneksikan 
$conn = mysqli_connect($hostname, $username, $password);
//membuat database
$query = "CREATE DATABASE IF NOT EXISTS modul5";
if (mysqli_query($conn, $query)){
	echo "Database created successfully";
}
else {
	echo "Error creating Database". mysqli_error($conn);
}

?>

