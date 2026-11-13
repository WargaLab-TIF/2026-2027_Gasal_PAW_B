<?php  
$conn = mysqli_connect("localhost", "root", "", "penjualan");

if (!$conn){
	die("koneksi database gagal:". mysqli_connet_error());
}
echo "koneksi database berhasil !<br>";
?>