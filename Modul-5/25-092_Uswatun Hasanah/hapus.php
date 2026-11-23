<?php
include 'koneksi.php';
mysqli_select_db($conn, "modul5");

$id = $_GET['id'];
$query = "DELETE FROM supplier WHERE id = $id";

 if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>