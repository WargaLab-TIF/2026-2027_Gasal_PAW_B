<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$id = trim($_GET['id'] ?? '');

if ($id === "") {
    echo "<script>
        alert('ID pelanggan tidak valid!');
        window.location.href = 'pelanggan.php';
    </script>";
    exit;
}

$stmt_cek = mysqli_prepare($conn, "SELECT id FROM transaksi WHERE pelanggan_id = ?");
mysqli_stmt_bind_param($stmt_cek, "s", $id);
mysqli_stmt_execute($stmt_cek);
mysqli_stmt_store_result($stmt_cek);

if (mysqli_stmt_num_rows($stmt_cek) > 0) {
    mysqli_stmt_close($stmt_cek);
    echo "<script>
        alert('Data pelanggan tidak boleh dihapus karena masih digunakan pada data transaksi!');
        window.location.href = 'pelanggan.php';
    </script>";
    exit;
}
mysqli_stmt_close($stmt_cek);

$stmt_del = mysqli_prepare($conn, "DELETE FROM pelanggan WHERE id = ?");
mysqli_stmt_bind_param($stmt_del, "s", $id);

if (mysqli_stmt_execute($stmt_del)) {
    mysqli_stmt_close($stmt_del);
    echo "<script>
        alert('Data pelanggan berhasil dihapus!');
        window.location.href = 'pelanggan.php';
    </script>";
    exit;
} else {
    mysqli_stmt_close($stmt_del);
    echo "<script>
        alert('Terjadi kesalahan pada sistem saat menghapus pelanggan.');
        window.location.href = 'pelanggan.php';
    </script>";
    exit;
}
?>

