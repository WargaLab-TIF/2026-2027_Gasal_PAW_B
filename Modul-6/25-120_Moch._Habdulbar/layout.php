<?php
// Tampilan atas halaman: Bootstrap, warna, dan menu navigasi
function tampilHeader($judul, $halaman) { ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f3ee; }
        .navbar { background-color: #355c5a; }
        .navbar .nav-link.active { font-weight: 600; }
        .card { border-color: #d9dfdb; }
        .card-header { background-color: #e8eeea; font-weight: 600; }
        .table th { background-color: #e8eeea !important; box-shadow: none !important; }
        .btn-primary {
            --bs-btn-bg: #4a7c74; --bs-btn-border-color: #4a7c74;
            --bs-btn-hover-bg: #3d6862; --bs-btn-hover-border-color: #3d6862;
            --bs-btn-active-bg: #355c5a; --bs-btn-active-border-color: #355c5a;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="transaksi.php">Penjualan</a>
        <div class="navbar-nav">
            <a class="nav-link <?= $halaman == 'transaksi' ? 'active' : '' ?>" href="transaksi.php">Transaksi</a>
            <a class="nav-link <?= $halaman == 'barang' ? 'active' : '' ?>" href="barang.php">Barang</a>
        </div>
    </div>
</nav>

<div class="container pb-4">
<?php }

// Tampilan bawah halaman
function tampilFooter() { ?>
</div>
</body>
</html>
<?php } ?>
