
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "modul5";

$conn = mysqli_connect(
    $hostname,
    $username,
    $password
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "CREATE DATABASE IF NOT EXISTS modul5";

if (mysqli_query($conn, $query)) {
    // Memilih database yang telah dibuat
    mysqli_select_db($conn, $dbname);
} else {
    die("Error database: " . mysqli_error($conn));
}

$query = "CREATE TABLE IF NOT EXISTS suplier (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    tlp VARCHAR(12) NOT NULL,
    alamat VARCHAR(50)
)";

if (mysqli_query($conn, $query)) {

    $cek = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM suplier"
    );

    $data = mysqli_fetch_assoc($cek);

    if ($data['total'] == 0) {
        $query = "INSERT INTO suplier (nama, tlp, alamat)
        VALUES
        ('PT. Maju Bersama', '08123456', 'Surabaya'),
        ('PT. Senang Sekali', '08155563', 'Bangkalan'),
        ('PT. Segar Segar', '0845454663', 'Surabaya')";

        mysqli_query($conn, $query);
    }
} else {
    die("Error tabel: " . mysqli_error($conn));
}
?>
