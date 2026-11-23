
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../koneksi.php';

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Transaksi Penjualan</h4>
        </div>

        <div class="card-body">
            <p>Silakan pilih menu transaksi untuk melakukan penjualan.</p>

            <a href="tambah.php" class="btn btn-success">
                + Tambah Transaksi
            </a>
        </div>
    </div>
</div>

</body>
</html>
