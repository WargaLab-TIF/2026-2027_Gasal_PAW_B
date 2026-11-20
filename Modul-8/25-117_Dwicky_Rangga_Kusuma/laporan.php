<?php
require_once "auth.php";
wajib_login();
awal_halaman("Laporan","Laporan");
?>
<table border="1"><tr><th>No</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th></tr>
<?php $q=mysqli_query($koneksi,"SELECT t.*,p.nama FROM transaksi t LEFT JOIN pelanggan p ON t.pelanggan_id=p.id ORDER BY t.waktu_transaksi DESC,t.id DESC");
$no=1;
$jumlah=0;
while($r=mysqli_fetch_assoc($q)) {
    $jumlah+=(int)$r['total'];
    echo '<tr><td>'.$no++.'</td><td>'.e($r['waktu_transaksi']).'</td><td>'.e($r['nama']).'</td><td>'.e($r['keterangan']).'</td><td>Rp '.number_format($r['total'],0,',','.').'</td></tr>';
}
?>
<tr><th colspan="4">Total Penjualan</th><th>Rp <?= number_format($jumlah,0,',','.') ?></th></tr>
</table>
<?php akhir_halaman();
?>
