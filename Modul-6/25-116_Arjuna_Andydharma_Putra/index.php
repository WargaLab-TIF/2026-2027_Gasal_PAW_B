<?php
require_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f6f9; }
        .navbar { background: linear-gradient(135deg, #1e3a5f, #2c5282); }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
    </style>
</head>
<body>
<nav class="navbar navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-shop"></i> Penjualan
        </a>
        <div class="d-flex gap-2">
            <a href="transaksi.php" class="btn btn-outline-light btn-sm">Transaksi</a>
            <a href="barang.php" class="btn btn-outline-light btn-sm">Barang</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row g-4 mb-4">
        <?php
        $tables = [
            ['supplier', 'Supplier', 'bi-truck', 'primary'],
            ['barang', 'Barang', 'bi-box-seam', 'success'],
            ['pelanggan', 'Pelanggan', 'bi-people', 'info'],
            ['transaksi', 'Transaksi', 'bi-receipt', 'warning'],
            ['transaksi_detail', 'Detail Transaksi', 'bi-list-ul', 'secondary'],
            ['pembayaran', 'Pembayaran', 'bi-cash-coin', 'danger'],
        ];
        foreach ($tables as $t) {
            $q = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM {$t[0]}");
            $jml = mysqli_fetch_assoc($q)['jml'];
            echo "
            <div class='col-md-4 col-sm-6'>
                <div class='card stat-card h-100'>
                    <div class='card-body d-flex align-items-center gap-3'>
                        <div class='bg-{$t[3]} bg-opacity-10 text-{$t[3]} rounded-3 p-3'>
                            <i class='bi {$t[2]} fs-3'></i>
                        </div>
                        <div>
                            <div class='text-muted small'>{$t[1]}</div>
                            <div class='fs-4 fw-bold'>{$jml}</div>
                        </div>
                    </div>
                </div>
            </div>";
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
