<?php
$conn = mysqli_connect("localhost", "root", "", "modul5");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM supplier WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);
}

header("Location: soal-1.php");
exit;
?>
