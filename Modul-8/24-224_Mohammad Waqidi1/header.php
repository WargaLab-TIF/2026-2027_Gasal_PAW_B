<?php 
if (!isset($judul)) {
    $judul = "Aplikasi Penjualan"; 
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($judul) ?></title>
    <link rel="stylesheet" href="../../24-224_Mohammad Waqidi/assets/style.css">
</head>
<body>


<nav>
    <a>Sistem Penjualan</a>
    <a href="../index.php">Home</a>
    <a href="../supplier/index.php">Data Master</a>
    <?php if ($_SESSION['role'] == 'admin') {?>
        <a href="../pelanggan/index.php">Laporan</a>
    <?php } ?>
</nav>

<main class="wrap">