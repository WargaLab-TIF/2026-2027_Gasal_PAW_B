<?php
session_start();

// $base diisi "../" oleh halaman yang ada di dalam folder
$base = $base ?? "";

// proteksi halaman: belum login -> ke halaman login
if (!isset($_SESSION['login'])) {
    header('location: ' . $base . 'login.php');
    exit();
}

// proteksi level: halaman data master hanya boleh dibuka owner (level 1)
function hanyaOwner()
{
    global $base;
    if ($_SESSION['level'] != 1) {
        header('location: ' . $base . 'index.php');
        exit();
    }
}
?>
