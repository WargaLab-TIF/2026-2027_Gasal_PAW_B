<?php
include 'koneksi.php';
include 'cek.php';
include 'header.php';

$level = ($_SESSION['level'] == 1) ? 'Owner' : 'Kasir';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h3>Selamat datang, <?= h($_SESSION['nama']) ?></h3>
        <p class="mb-0">Anda login sebagai <b><?= $level ?></b>.</p>
    </div>
</div>
<?php include 'footer.php'; ?>
