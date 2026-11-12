
<?php
require_once 'koneksi.php';

if (isset($_POST['transaksi_id']) && isset($_POST['barang_id'])) {

    $transaksi_id = (int) $_POST['transaksi_id'];
    $barang_id = (int) $_POST['barang_id'];

    
    $query_hapus = mysqli_query($koneksi, "
        DELETE FROM transaksi_detail
        WHERE transaksi_id = $transaksi_id
        AND barang_id = $barang_id
    ");

    if ($query_hapus) {

        
        $query_total = mysqli_query($koneksi, "
            SELECT COALESCE(SUM(harga * qty), 0) AS total
            FROM transaksi_detail
            WHERE transaksi_id = $transaksi_id
        ");

        $data_total = mysqli_fetch_assoc($query_total);
        $total = $data_total['total'];

        
        mysqli_query($koneksi, "
            UPDATE transaksi
            SET total = $total
            WHERE id = $transaksi_id
        ");
    }

    header("Location: transaksi.php?id=$transaksi_id");
    exit;
}
?>
