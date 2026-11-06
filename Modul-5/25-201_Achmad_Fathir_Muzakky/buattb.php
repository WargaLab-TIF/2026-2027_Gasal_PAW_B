<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsupply";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully <br>";

$createtb = "CREATE TABLE data(
    nomor INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    telp VARCHAR(255) NOT NULL,
    alamat VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $createtb)) {   
    echo "Table created successfully";
} else {
    echo "Error" . mysqli_error($conn);
}

mysqli_close($conn);
?>
