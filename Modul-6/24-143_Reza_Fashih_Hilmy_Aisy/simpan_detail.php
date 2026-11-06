<?php
include "koneksi.php";

$transaksi_id = (int) $_POST['transaksi_id'];
$barang_id = (int) $_POST['barang_id'];
$qty = (int) $_POST['qty'];

if ($transaksi_id <= 0 || $barang_id <= 0 || $qty <= 0) {
    header("Location: transaksi.php?id=$transaksi_id&error=1&status=Data tidak valid");
    exit;
}

// Mengambil harga barang
$query_barang = mysqli_query($conn, "
    SELECT * FROM barang
    WHERE id = $barang_id
");

$barang = mysqli_fetch_assoc($query_barang);

if (!$barang) {
    header("Location: transaksi.php?id=$transaksi_id&error=1&status=Barang tidak ditemukan");
    exit;
}

$harga = $barang['harga'];

// Memeriksa barang yang sudah dimasukkan
$query_cek = mysqli_query($conn, "
    SELECT * FROM transaksi_detail
    WHERE transaksi_id = $transaksi_id
    AND barang_id = $barang_id
");

if (mysqli_num_rows($query_cek) > 0) {

    header("Location: transaksi.php?id=$transaksi_id&error=1&status=Barang sudah dimasukkan");
    exit;

} else {

   
    $query_simpan = mysqli_query($conn, "
        INSERT INTO transaksi_detail
        (transaksi_id, barang_id, harga, qty)
        VALUES
        ($transaksi_id, $barang_id, $harga, $qty)
    ");

    if ($query_simpan) {

        
        $query_total = mysqli_query($conn, "
            SELECT COALESCE(SUM(harga * qty), 0) AS total
            FROM transaksi_detail
            WHERE transaksi_id = $transaksi_id
        ");

        $data_total = mysqli_fetch_assoc($query_total);
        $total = $data_total['total'];

       
        $query_update = mysqli_query($conn, "
            UPDATE transaksi
            SET total = $total
            WHERE id = $transaksi_id
        ");

        if ($query_update) {
            header("Location: transaksi.php?id=$transaksi_id&status=Detail berhasil disimpan");
        } else {
            header("Location: transaksi.php?id=$transaksi_id&error=1&status=Gagal memperbarui total");
        }

    } else {

        header("Location: transaksi.php?id=$transaksi_id&error=1&status=Gagal menyimpan detail");
    }
}

exit;
?>