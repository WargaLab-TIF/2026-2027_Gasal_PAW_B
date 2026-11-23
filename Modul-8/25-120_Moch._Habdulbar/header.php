<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Sistem Penjualan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
<style>
.navbar-inverse{background:#1b4a8a;border-color:#163c70}
.navbar-inverse .navbar-nav>li>a,.navbar-inverse .navbar-brand{color:#fff}
.navbar-inverse .navbar-nav>li>a:hover,.navbar-inverse .navbar-nav>.open>a,.navbar-inverse .navbar-nav>.open>a:hover{background:#163c70;color:#fff}
.navbar-inverse .dropdown-menu{background:#fff}
.navbar-inverse .dropdown-menu>li>a{color:#333}
.navbar-inverse .dropdown-menu>li>a:hover{background:#f5f5f5;color:#333}
</style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Sistem Penjualan</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <?php if ($_SESSION['level'] == 1) { ?>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Data Master <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="barang.php">Data Barang</a></li>
          <li><a href="supplier.php">Data Supplier</a></li>
          <li><a href="pelanggan.php">Data Pelanggan</a></li>
          <li><a href="user.php">Data User</a></li>
        </ul>
      </li>
      <?php } ?>
      <li><a href="transaksi.php">Transaksi</a></li>
      <li><a href="laporan.php">Laporan</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= h($_SESSION['nama']) ?> <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<div class="container">
<?php if (isset($_SESSION['flash'])) { ?>
  <div class="alert alert-success"><?= h($_SESSION['flash']) ?></div>
<?php unset($_SESSION['flash']); } ?>
