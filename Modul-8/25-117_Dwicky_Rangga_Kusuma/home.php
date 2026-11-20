<?php
require_once "auth.php";
awal_halaman("Home", "Home");
echo "<p>Selamat datang, <b>".e($_SESSION['nama'])."</b>.</p>";
echo "<p>Anda login sebagai <b>".((int)$_SESSION['level']===1 ? "Owner (Level 1)" : "Kasir (Level 2)")."</b>.</p>";
echo "<p>Silakan pilih menu pada navigasi di atas.</p>";
akhir_halaman();
