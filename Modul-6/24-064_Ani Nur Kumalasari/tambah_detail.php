
<?php
include "koneksi.php";

if (isset($_POST['tambah'])) {

    $transaksi_id = (int) $_POST['transaksi_id'];
    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if ($transaksi_id <= 0 || $barang_id <= 0 || $qty <= 0) {
        die("Data tidak valid!");
    }

    // Mengambil harga barang dari tabel barang
    $query_barang = mysqli_query($koneksi, "
        SELECT harga FROM barang
        WHERE id = '$barang_id'
    ");

    $barang = mysqli_fetch_assoc($query_barang);

    if (!$barang) {
        die("Barang tidak ditemukan!");
    }

    $harga = $barang['harga'];

    // Menghitung subtotal
    $subtotal = $harga * $qty;

    // Menyimpan barang ke detail transaksi
    $query = mysqli_query($koneksi, "
        INSERT INTO transaksi_detail
        (transaksi_id, barang_id, harga, qty)
        VALUES ('$transaksi_id', '$barang_id', '$harga', '$qty')
    ");

    if ($query) {

        // Menghitung total transaksi
        $hitung = mysqli_query($koneksi, "
            SELECT SUM(harga * qty) AS total
            FROM transaksi_detail
            WHERE transaksi_id = '$transaksi_id'
        ");

        $data = mysqli_fetch_assoc($hitung);
        $total = $data['total'];

        // Memperbarui total transaksi
        mysqli_query($koneksi, "
            UPDATE transaksi
            SET total = '$total'
            WHERE id = '$transaksi_id'
        ");

        header("Location: detail_transaksi.php?id=" . $transaksi_id);
        exit;

    } else {
        echo "Gagal menambahkan barang: " . mysqli_error($koneksi);
    }

} else {
    header("Location: master-detail.php");
    exit;
}
?>
