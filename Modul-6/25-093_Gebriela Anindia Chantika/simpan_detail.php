<?php
require_once "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$transaksi_id = isset($_POST['transaksi_id']) ? (int) $_POST['transaksi_id'] : 0;
$barang_id = isset($_POST['barang_id']) ? (int) $_POST['barang_id'] : 0;
$qty = isset($_POST['qty']) ? (int) $_POST['qty'] : 0;

if ($transaksi_id < 1 || $barang_id < 1 || $qty < 1) {
    die("Data tidak valid. Pastikan semua sudah diisi.");
}

mysqli_begin_transaction($koneksi);

try {

    $stmt = mysqli_prepare($koneksi, "
        SELECT id FROM transaksi WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
    mysqli_stmt_execute($stmt);

    $transaksi = mysqli_stmt_get_result($stmt);

    if (!mysqli_fetch_assoc($transaksi)) {
        throw new Exception("Transaksi tidak ditemukan.");
    }

    $stmt = mysqli_prepare($koneksi, "
        SELECT harga FROM barang WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, "i", $barang_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $barang = mysqli_fetch_assoc($result);

    if (!$barang) {
        throw new Exception("Barang tidak ditemukan.");
    }

    $harga = (int) $barang['harga'];

    $stmt = mysqli_prepare($koneksi, "
        SELECT barang_id
        FROM transaksi_detail
        WHERE transaksi_id = ?
        AND barang_id = ?
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $transaksi_id,
        $barang_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        throw new Exception(
            "Barang tersebut sudah digunakan pada transaksi ini."
        );
    }

    $stmt = mysqli_prepare($koneksi, "
        INSERT INTO transaksi_detail
        (transaksi_id, barang_id, harga, qty)
        VALUES (?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "iiii",
        $transaksi_id,
        $barang_id,
        $harga,
        $qty
    );

    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi, "
        UPDATE transaksi
        SET total = (
            SELECT COALESCE(SUM(harga * qty), 0)
            FROM transaksi_detail
            WHERE transaksi_id = ?
        )
        WHERE id = ?
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $transaksi_id,
        $transaksi_id
    );

    mysqli_stmt_execute($stmt);

    mysqli_commit($koneksi);

    header("Location: detail.php?id=" . $transaksi_id);
    exit;

} catch (Throwable $e) {

    mysqli_rollback($koneksi);

    die(
        "Gagal menyimpan detail: " .
        htmlspecialchars($e->getMessage()) .
        '<br><a href="tambah.php?id=' . $transaksi_id . '">Kembali</a>'
    );
}

?>