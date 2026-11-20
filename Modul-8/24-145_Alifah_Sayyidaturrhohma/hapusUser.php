<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    echo "<script>
        alert('ID user tidak valid!');
        window.location.href = 'user.php';
    </script>";
    exit;
}

if ($id === (int)$_SESSION['id_user']) {
    echo "<script>
        alert('Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan!');
        window.location.href = 'user.php';
    </script>";
    exit;
}

$stmt_cek = mysqli_prepare($conn, "SELECT id_user FROM user WHERE id_user = ?");
mysqli_stmt_bind_param($stmt_cek, "i", $id);
mysqli_stmt_execute($stmt_cek);
mysqli_stmt_store_result($stmt_cek);

if (mysqli_stmt_num_rows($stmt_cek) === 0) {
    mysqli_stmt_close($stmt_cek);
    echo "<script>
        alert('Data user tidak ditemukan!');
        window.location.href = 'user.php';
    </script>";
    exit;
}
mysqli_stmt_close($stmt_cek);

$stmt_del = mysqli_prepare($conn, "DELETE FROM user WHERE id_user = ?");
mysqli_stmt_bind_param($stmt_del, "i", $id);

if (mysqli_stmt_execute($stmt_del)) {
    mysqli_stmt_close($stmt_del);
    echo "<script>
        alert('Data user berhasil dihapus!');
        window.location.href = 'user.php';
    </script>";
    exit;
} else {
    mysqli_stmt_close($stmt_del);
    echo "<script>
        alert('Terjadi kesalahan sistem saat menghapus data user.');
        window.location.href = 'user.php';
    </script>";
    exit;
}
?>

