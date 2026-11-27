<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    echo "<script>
        alert('ID supplier tidak valid!');
        window.location.href = 'supplier.php';
    </script>";
    exit;
}

$stmt_cek = mysqli_prepare($conn, "SELECT id FROM barang WHERE supplier_id = ?");
mysqli_stmt_bind_param($stmt_cek, "i", $id);
mysqli_stmt_execute($stmt_cek);
mysqli_stmt_store_result($stmt_cek);

if (mysqli_stmt_num_rows($stmt_cek) > 0) {
    mysqli_stmt_close($stmt_cek);
    echo "<script>
        alert('Data supplier tidak boleh dihapus karena masih digunakan pada data barang!');
        window.location.href = 'supplier.php';
    </script>";
    exit;
}
mysqli_stmt_close($stmt_cek);

$stmt_del = mysqli_prepare($conn, "DELETE FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($stmt_del, "i", $id);

if (mysqli_stmt_execute($stmt_del)) {
    mysqli_stmt_close($stmt_del);
    echo "<script>
        alert('Data supplier berhasil dihapus!');
        window.location.href = 'supplier.php';
    </script>";
    exit;
} else {
    mysqli_stmt_close($stmt_del);
    echo "<script>
        alert('Terjadi kesalahan pada sistem saat menghapus data supplier.');
        window.location.href = 'supplier.php';
    </script>";
    exit;
}
?>

