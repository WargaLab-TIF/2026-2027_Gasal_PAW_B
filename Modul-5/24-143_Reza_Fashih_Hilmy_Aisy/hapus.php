
<?php

include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM supplier WHERE id='$id'");

if ($query) {
    header("Location: index.php");
    exit;
} else {
    echo "Data gagal dihapus";
}

?>
