<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $query = "DELETE FROM supplier WHERE id=?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location='index.php';
              </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID supplier tidak valid.";
}
?>