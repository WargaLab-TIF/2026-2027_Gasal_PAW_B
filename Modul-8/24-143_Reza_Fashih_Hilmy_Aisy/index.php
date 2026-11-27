<?php
require_once 'auth.php';

if (isset($_POST['logout'])) {
    session_destroy();
    session_unset();
    header("Location: login.php");
    exit();
}

require_login();
include "koneksi.php";

$query_barang = mysqli_query($conn, "SELECT * FROM barang");
$query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi");
$query_pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$query_supplier = mysqli_query($conn, "SELECT * FROM supplier");

$jumlah_barang = mysqli_num_rows($query_barang);
$jumlah_transaksi = mysqli_num_rows($query_transaksi);
$jumlah_pelanggan = mysqli_num_rows($query_pelanggan);
$jumlah_supplier = mysqli_num_rows($query_supplier);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: whitesmoke; margin: 30px; color: darkslategray; }
        h2 { color: cadetblue; }
        .app-nav { display: flex; align-items: center; flex-wrap: wrap; gap: 5px; margin-bottom: 25px; }
        .app-nav a, .logout-form input { display: inline-block; background-color: cadetblue; color: white; text-decoration: none; padding: 10px 13px; border: 0; border-radius: 5px; cursor: pointer; }
        .app-nav a:hover, .logout-form input:hover { background-color: darkslategray; }
        .user-info { margin: 5px 10px; }
        .dropdown { position: relative; display: inline-block; }
        .dropdown-content { display: none; position: absolute; background: white; min-width: 160px; z-index: 1; box-shadow: 0 4px 8px #999; }
        .dropdown-content a { display: block; border-radius: 0; }
        .dropdown:hover .dropdown-content { display: block; }
        .logout-form { margin: 0; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; background-color: white; }
        th { background-color: lightblue; color: darkslategray; }
        th, td { border: 1px solid lightgray; padding: 10px; text-align: left; }
    </style>
</head>
<body>
<?php app_nav(); ?>
<h2>Aplikasi Penjualan</h2>
<h3>Home</h3>
<table>
    <tr><th>Nama Data</th><th>Jumlah Data</th></tr>
    <?php if ($_SESSION['level'] == 1) { ?>
    <tr><td>Barang</td><td><?php echo $jumlah_barang; ?></td></tr>
    <tr><td>Supplier</td><td><?php echo $jumlah_supplier; ?></td></tr>
    <tr><td>Pelanggan</td><td><?php echo $jumlah_pelanggan; ?></td></tr>
    <?php } ?>
    <tr><td>Transaksi</td><td><?php echo $jumlah_transaksi; ?></td></tr>
</table>
</body>
</html>
