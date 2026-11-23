<?php
require_once "auth.php";
wajib_login();
if (isset($_POST['simpan']))  {
    $tanggal = $_POST['waktu_transaksi'];
    $keterangan = $_POST['keterangan'];
    $pelanggan = $_POST['pelanggan_id'];
    $stmt = mysqli_prepare($koneksi, "INSERT INTO transaksi (waktu_transaksi,keterangan,total,pelanggan_id) VALUES (?,?,0,?)");
    mysqli_stmt_bind_param($stmt, "sss", $tanggal, $keterangan, $pelanggan);
    if (mysqli_stmt_execute($stmt))  {
        header("Location: detail.php?id=".mysqli_insert_id($koneksi));
        exit;
    }
}
awal_halaman("Data Transaksi", "Transaksi");
?>
<h3>Tambah Transaksi Baru</h3>
<form method="post"><table>
<tr><td>Tanggal</td><td><input type="date" name="waktu_transaksi" required></td></tr>
<tr><td>Pelanggan</td><td><select name="pelanggan_id" required><option value="">-- Pilih Pelanggan --</option>
<?php $q=mysqli_query($koneksi,"SELECT id,nama FROM pelanggan ORDER BY nama");
while($p=mysqli_fetch_assoc($q)) echo '<option value="'.e($p['id']).'">'.e($p['nama']).'</option>';
?>
</select></td></tr>
<tr><td>Keterangan</td><td><textarea name="keterangan"></textarea></td></tr>
<tr><td></td><td><input type="submit" name="simpan" value="Simpan Transaksi"></td></tr>
</table></form>
<h3>Daftar Transaksi</h3>
<table border="1"><tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th><th>Detail</th></tr>
<?php
$q=mysqli_query($koneksi,"SELECT t.*,p.nama FROM transaksi t LEFT JOIN pelanggan p ON t.pelanggan_id=p.id ORDER BY t.id DESC");
while($r=mysqli_fetch_assoc($q))  {
    echo '<tr><td>'.e($r['id']).'</td><td>'.e($r['waktu_transaksi']).'</td><td>'.e($r['nama']).'</td><td>'.e($r['keterangan']).'</td><td>Rp '.number_format($r['total'],0,',','.').'</td><td><a href="detail.php?id='.$r['id'].'">Lihat Detail</a></td></tr>';
}
?>
</table>
<?php akhir_halaman();
?>
