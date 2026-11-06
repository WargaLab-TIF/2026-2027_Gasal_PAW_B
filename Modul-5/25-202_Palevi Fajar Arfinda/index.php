<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_supplier";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";

// $query = "CREATE DATABASE db_supplier";
// if (mysqli_connect($conn, $query)) {
// 	echo "Database created successfully";
// } else {
// 	echo "Error creating database: " . mysqli_error($conn);
// }

// $sql = "CREATE TABLE data_master_supplier (
// Nomor INT(6) AUTO_INCREMENT PRIMARY KEY,
// Nama VARCHAR(30) NOT NULL,
// Telp VARCHAR(30) NOT NULL,
// Alamat VARCHAR(50) NOT NULL
// )";

// if (mysqli_query($conn, $sql)) {
// 	echo "Tabel created successfully";
// } else {
// 	echo "Error creating database: " . mysqli_error($conn);
// }

$query = "SELECT Nomor, Nama, Telp, Alamat FROM data_master_supplier";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "Data Master Supplier:<br>";
    echo "<table border='1'>";
    echo "<tr><th>nomor</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>tindakan</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["Nomor"] . "</td>";
        echo "<td>" . $row["Nama"] . "</td>";
        echo "<td>" . $row["Telp"] . "</td>";
        echo "<td>" . $row["Alamat"] . "</td>";
        echo "<td>";
        echo "<a href='edit.php?nomor=" . $row["Nomor"] . "'><input type='button' value='Edit'></a> ";
        echo "<a href='hapus.php?nomor=" . $row["Nomor"] . "' onclick=\"return confirm('Anda yakin akan menghapus supplier ini?');\"><input type='button' value='Hapus'></a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 result";
}

mysqli_close($conn);
?>
<br>
<a href="tambah.php"><input type="button" name="tambah" value="Tambah Data"></a>
