<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbsupplier";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}

$query = "INSERT INTO supplier (nama, telp, alamat) VALUES
  ('PT. Maju Bersama', '08123456',  'Surabaya'),
  ('PT. Senang Sekali', '081515563', 'Bangkalan'),
  ('PT. Segar Segar', '0845454663', 'Surabaya')";

if (mysqli_query($conn, $query)) {
  echo "Data supplier berhasil ditambahkan!";
} else {
  echo "Error: ".mysqli_error($conn);
}

mysqli_close($conn);
?>
