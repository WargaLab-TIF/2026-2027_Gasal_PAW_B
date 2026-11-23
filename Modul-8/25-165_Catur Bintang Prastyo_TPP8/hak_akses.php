<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header('Location: soal1_login.php');
    exit;
}

$namaUser = $_SESSION['nama'] ?? 'User';
$levelUser = (int) ($_SESSION['level'] ?? 0);

function wajibLevel(array $allowedLevels): void
{
    $currentLevel = (int) ($_SESSION['level'] ?? 0);
    if (!in_array($currentLevel, $allowedLevels, true)) {
        http_response_code(403);
        echo 'Akses ditolak. Anda tidak memiliki hak akses ke halaman ini.';
        exit;
    }
}
?>
<nav style="display:flex; gap:16px; align-items:center; padding:10px; background:#1e293b; color:#fff;">
    <strong>Sistem Penjualan</strong>
    <a href="index.php" style="color:#fff;">Home</a>

    <?php if ($levelUser === 1): ?>
        <!-- Level 1: Owner -->
        <div class="dropdown">
            <span>Data Master ▾</span>
            <ul>
                <li><a href="master/barang.php">Data Barang</a></li>
                <li><a href="master/supplier.php">Data Supplier</a></li>
                <li><a href="master/pelanggan.php">Data Pelanggan</a></li>
                <li><a href="master/user.php">Data User</a></li>
            </ul>
        </div>
        <a href="transaksi/index.php" style="color:#fff;">Transaksi</a>
        <a href="laporan/index.php" style="color:#fff;">Laporan</a>
    <?php elseif ($levelUser === 2): ?>
        <!-- Level 2: Kasir -->
        <a href="transaksi/index.php" style="color:#fff;">Transaksi</a>
        <a href="laporan/index.php" style="color:#fff;">Laporan</a>
    <?php endif; ?>

    <span style="margin-left:auto;">
        Halo, <strong><?= htmlspecialchars($namaUser, ENT_QUOTES, 'UTF-8') ?></strong>
        | <a href="soal3_logout.php" style="color:#fca5a5;">Logout</a>
    </span>
</nav>