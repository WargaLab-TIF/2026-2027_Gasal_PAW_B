<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsupply";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT nomor, nama, alamat, telp FROM data";
$result =mysqli_query($conn, $query);

echo "<h2>Data Master Supplier</h2>";
echo "<a href='tambah.php'><button>Tambah Data</button></a>";
echo "<br><br>";

echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr>";
echo "<th>No</th>";
echo "<th>Nama</th>";
echo "<th>Telp</th>";
echo "<th>Alamat</th>";
echo "<th>Tindakan</th>";
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["nomor"] . "</td>";
    echo "<td>" . $row["nama"] . "</td>";
    echo "<td>" . $row["alamat"] . "</td>";
    echo "<td>" . $row["telp"] . "</td>";
    echo "<td>";
    echo "<a href='edit.php?nomor=" . $row["nomor"] . "'><button>Edit</button></a>" . " ";
    echo "<a href='hapus.php?nomor=" . $row["nomor"] . "' onclick=\"return confirm('Anda yakin akan menghapus supplier ini?');\"><button>Hapus</button></a>";
    echo "</td>";
}
echo "</table>";

?>