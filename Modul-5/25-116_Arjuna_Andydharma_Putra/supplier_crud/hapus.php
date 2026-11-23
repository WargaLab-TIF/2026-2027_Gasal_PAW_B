<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_supplier";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$id = $_GET['id'];
$sql = "DELETE FROM supplier WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
    header("Location: index.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
