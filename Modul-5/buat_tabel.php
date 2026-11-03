<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "modul5";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "CREATE TABLE IF NOT EXISTS supplier (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $query)) {
    echo "Table supplier berhasil dibuat!<br>";
} else {
    echo "Error: " . mysqli_error($conn);
}

$query = "SELECT * FROM supplier";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    $query = "INSERT INTO supplier (nama, telp, alamat)
              VALUES
              ('PT. Maju Bersama', '08123456', 'Surabaya'),
              ('PT. Senang Sekali', '081515563', 'Bangkalan'),
              ('PT. Segar Segar', '0845454663', 'Surabaya')";

    if (mysqli_query($conn, $query)) {
        echo "Data supplier berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Data supplier sudah tersedia.";
}

mysqli_close($conn);
?>