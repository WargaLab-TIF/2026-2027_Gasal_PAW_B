<?php require_once 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Home Penjualan</title></head>
<body>
<h2>Home</h2>
<p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong>.</p>
<p>Anda login sebagai <?= $_SESSION['level'] == 1 ? 'Owner' : 'Kasir' ?>.</p>
<p>Silakan pilih menu pada navigasi di atas.</p>
</body>
</html>
