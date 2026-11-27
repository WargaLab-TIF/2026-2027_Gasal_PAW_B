<?php
session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

function require_login() {
    if (!$_SESSION['login']) {
        header("Location: login.php");
        exit();
    }
}

function require_owner() {
    require_login();
    if ($_SESSION['level'] != 1) {
        header("Location: index.php");
        exit();
    }
}

function app_nav() {
    echo '<style>.app-nav{display:flex;align-items:center;flex-wrap:wrap;gap:5px;margin-bottom:20px}.app-nav a,.logout-form input{display:inline-block;background:cadetblue;color:white;text-decoration:none;padding:9px 12px;border:0;border-radius:5px;cursor:pointer}.app-nav a:hover,.logout-form input:hover{background:darkslategray}.dropdown{position:relative;display:inline-block}.dropdown-content{display:none;position:absolute;background:white;min-width:160px;z-index:10;box-shadow:0 4px 8px #999}.dropdown-content a{display:block;border-radius:0}.dropdown:hover .dropdown-content{display:block}.user-info{margin:5px 10px}.logout-form{margin:0}</style>';
    echo '<nav class="app-nav">';
    echo '<a href="index.php">Home</a>';
    if ($_SESSION['level'] == 1) {
        echo '<div class="dropdown"><a href="data_master.php">Data Master</a><div class="dropdown-content">';
        echo '<a href="barang.php">Data Barang</a>';
        echo '<a href="supplier.php">Data Supplier</a>';
        echo '<a href="pelanggan.php">Data Pelanggan</a>';
        echo '<a href="user.php">Data User</a>';
        echo '</div></div>';
    }
    echo '<a href="transaksi.php">Transaksi</a>';
    echo '<a href="laporan.php">Laporan</a>';
    echo '<span class="user-info">Nama: ' . htmlspecialchars($_SESSION['nama']) . '</span>';
    echo '<form action="index.php" method="POST" class="logout-form">';
    echo '<input type="submit" name="logout" value="Logout">';
    echo '</form>';
    echo '</nav>';
}
?>
