<?php 
$query = "CREATE DATABASE data_supplier";

if (mysqli_query($conn,$query)) {
	echo "database created successfully";
} else {
	echo "error creating database";
}


$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "data_supplier"

$conn = mysqli_connect($hostame,$username,$password,$dbname);

if (!$conn) {
	die("connection failed: ".mysqli_connect_error());
}

echo "connection succesfull";

$query = "CREATE TABLE Data (
	id INT(11) AUTO_INCREMENT PRIMARY KEY,
	nama VARCHAR(255) NOT NULL,
	telepon VARCHAR(12) NOT NULL,
	alamat VARCHAR(50)
)";

if(mysqli_query($conn,$query)){
	echo "table mahasiswa berhasil dibuat!";
} else {
	echo "Error : ". mysqli_error($conn) ;
}

 ?>