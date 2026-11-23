<?php
include 'koneksi.php';
wajib_login();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home Penjualan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php menu(); ?>

<main>
  <h2>Selamat datang, <?= htmlspecialchars($_SESSION['nama']); ?>!</h2>

  <p>
    Anda masuk sebagai
    <b><?= $_SESSION['level'] == 1 ? 'Owner' : 'Kasir'; ?></b>.
  </p>

  <p>Pilih menu pada navigasi untuk mengelola penjualan.</p>

  <?php if ($_SESSION['level'] == 1) { ?>
    <p>Owner dapat membuka Data Master (Barang, Supplier, Pelanggan, User), Transaksi, dan Laporan.</p>
  <?php } else { ?>
    <p>Kasir dapat membuka Home, Transaksi, dan Laporan.</p>
  <?php } ?>
</main>

</body>
</html>