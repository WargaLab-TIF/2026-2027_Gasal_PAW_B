<?php
include 'cek_login.php';
include 'navbar.php';
?>
<h2>Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?></h2>
<p>Anda login sebagai: <?= $_SESSION['level'] == 1 ? 'Owner' : 'Kasir' ?></p>
