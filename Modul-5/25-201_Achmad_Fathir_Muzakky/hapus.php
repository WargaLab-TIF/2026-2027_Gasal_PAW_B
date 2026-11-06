<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "dbsupply";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$nomor = $_GET['nomor'];
$sql = "DELETE FROM data WHERE nomor = $nomor";
if (mysqli_query($conn, $sql)) {
    echo "Data Berhasil Dihapus";
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
