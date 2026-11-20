<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'penjualan');
if (!$conn) {
  die('Koneksi database gagal: ' . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8mb4');

function wajib_login($owner = false) {
  if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
  }
  if ($owner && $_SESSION['level'] != 1) {
    header('Location: index.php');
    exit;
  }
}

function menu() {
  echo '<nav>';
  echo '<a href="index.php">Home</a>';
  if ($_SESSION['level'] == 1) {
    echo '<span>Data Master:</span>';
    echo '<a href="barang.php">Barang</a>';
    echo '<a href="supplier.php">Supplier</a>';
    echo '<a href="pelanggan.php">Pelanggan</a>';
    echo '<a href="user.php">User</a>';
  }
  echo '<a href="transaksi.php">Transaksi</a>';
  echo '<a href="laporan.php">Laporan</a>';
  echo '<span class="akun">' . htmlspecialchars($_SESSION['nama']) . ' (' . ($_SESSION['level'] == 1 ? 'Owner' : 'Kasir') . ')</span>';
  echo '<form method="post" action="logout.php" class="logout"><button type="submit">Logout</button></form>';
  echo '</nav>';
}
?>
