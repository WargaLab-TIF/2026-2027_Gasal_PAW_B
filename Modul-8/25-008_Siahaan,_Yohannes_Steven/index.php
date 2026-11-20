<?php
require "koneksi.php";
include "midlewire.php";
require "fungsi.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Sistem Penjualan</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Halaman Utama (Home)</h2>
    <p>Selamat datang, <b><?= htmlspecialchars($_SESSION['nama']) ?></b>!</p>
    <p>Username: <?= htmlspecialchars($_SESSION['username']) ?></p>
    <p>Hak Akses: <?= $_SESSION['level'] == 1 ? "Level 1 (Owner)" : "Level 2 (Kasir)" ?></p>
</body>
</html>
