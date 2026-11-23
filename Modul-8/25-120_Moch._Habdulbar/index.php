<?php
require 'config.php';
wajib_login();
include 'header.php';
?>
<div class="jumbotron">
  <h2>Selamat datang, <?= h($_SESSION['nama']) ?></h2>
  <p>Anda login sebagai <?= $_SESSION['level'] == 1 ? 'Owner' : 'Kasir' ?>.</p>
</div>
<?php include 'footer.php'; ?>
