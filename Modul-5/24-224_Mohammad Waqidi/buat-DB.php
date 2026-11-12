
<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "Koneksi berhasil!<br>";

$sql = "CREATE DATABASE IF NOT EXISTS modul_5";

if (mysqli_query($conn, $sql)) {
    echo "Database berhasil dibuat!<br>";
} else {
    die("Error: " . mysqli_error($conn));
}

mysqli_select_db($conn, "modul_5");

$sql = "CREATE TABLE IF NOT EXISTS suplier (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    telpon VARCHAR(12) NOT NULL,
    alamat VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Tabel suplier berhasil dibuat!<br>";
} else {
    die("Error: " . mysqli_error($conn));
}

$sql = "INSERT INTO suplier (nama, telpon, alamat) VALUES
    ('PT. Maju Bersama', '08123456', 'Surabaya'),
    ('PT. Senang Sekali', '081515563', 'Bangkalan'),
    ('PT. Segar Segar', '0845454663', 'Surabaya')";

if (mysqli_query($conn, $sql)) {
    echo "Data berhasil ditambahkan!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
