<?php
include "koneksi.php";

$id = $_GET["id"];

$sql = "DELETE FROM supplier WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
