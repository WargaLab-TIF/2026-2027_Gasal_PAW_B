<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_supplier";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "INSERT INTO supplier (nama, telp, alamat) VALUES
('PT. Maju Bersama', '08123456', 'Surabaya'),
('PT. Senang Sekali', '081515563', 'Bangkalan'),
('PT. Segar Segar', '0845454663', 'Surabaya')";

if (mysqli_query($conn, $query)) {
    echo "Data awal berhasil ditambahkan.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>