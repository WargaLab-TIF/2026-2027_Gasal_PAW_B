<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "db_supplier";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['nomor'])) {
    $nomor = htmlspecialchars($_GET['nomor']);

    $sql = "DELETE FROM data_master_supplier WHERE Nomor = $nomor";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error saat menghapus: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>