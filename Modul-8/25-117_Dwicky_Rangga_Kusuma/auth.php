<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "koneksi.php";
function e($v)  {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
function wajib_login()  {
    if (!isset($_SESSION['id_user']))  {
        header("Location: login.php");
        exit;
    }
}
function wajib_owner()  {
    wajib_login();
    if ((int)$_SESSION['level'] !== 1)  {
        http_response_code(403);
        echo "<h2>Akses ditolak</h2><p>Halaman ini hanya dapat diakses Owner.</p><a href='home.php'>Kembali</a>";
        exit;
    }
}
function navigasi($aktif = '')  {
    echo '<div class="nav">';
    echo '<a '.($aktif==='Home'?'class="aktif"':'').' href="home.php">Home</a>';
    if ((int)$_SESSION['level'] === 1)  {
        echo '<div class="dropdown"><a '.($aktif==='Data Master'?'class="aktif"':'').'>Data Master ▾</a><div class="isi-dropdown">';
        echo '<a href="barang.php">Data Barang</a><a href="supplier.php">Data Supplier</a><a href="pelanggan.php">Data Pelanggan</a><a href="user.php">Data User</a>';
        echo '</div></div>';
    }
    echo '<a '.($aktif==='Transaksi'?'class="aktif"':'').' href="index.php">Transaksi</a>';
    echo '<a '.($aktif==='Laporan'?'class="aktif"':'').' href="laporan.php">Laporan</a>';
    echo '<span class="nama-user">Login: '.e($_SESSION['nama']).'</span>';
    echo '<a href="logout.php" onclick="return confirm(\'Yakin ingin logout?\')">Logout</a>';
    echo '</div>';
}
function awal_halaman($judul, $aktif='')  {
    wajib_login();
    echo '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>'.e($judul).'</title><link rel="stylesheet" href="style.css"></head><body>';
    echo '<h1>Aplikasi Penjualan</h1>';
    navigasi($aktif);
    echo '<h2>'.e($judul).'</h2>';
}
function akhir_halaman()  {
    echo '</body></html>';
}
