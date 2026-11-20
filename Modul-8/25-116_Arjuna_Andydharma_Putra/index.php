<?php
include 'koneksi.php';
cek_login(); // proteksi halaman
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Sistem Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f6fa; }
        .container { padding: 30px; }
        .welcome {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
        h2 { margin-top: 0; color: #2c3e50; }
        .info { color: #555; line-height: 1.6; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="welcome">
            <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</h2>
            <div class="info">
                <p>Anda login sebagai <b><?= $_SESSION['level'] == 1 ? 'Owner (Level 1)' : 'Kasir (Level 2)' ?></b>.</p>
                <?php if ($_SESSION['level'] == 1) { ?>
                    <p>Sebagai Owner Anda bisa mengakses semua menu: Data Master (Barang, Supplier, Pelanggan, User), Transaksi, dan Laporan.</p>
                <?php } else { ?>
                    <p>Sebagai Kasir Anda hanya bisa mengakses menu Transaksi dan Laporan.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
