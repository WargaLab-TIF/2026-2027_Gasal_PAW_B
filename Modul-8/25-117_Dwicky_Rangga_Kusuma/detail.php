<?php
require_once "auth.php";
wajib_login();
if (!isset($_GET['id'])) die("Transaksi belum dipilih. <a href='index.php'>Kembali</a>");
$id=(int)$_GET['id'];
$pesan="";
if (isset($_POST['simpan_detail']))  {
    $barang=(int)$_POST['barang_id'];
    $qty=(int)$_POST['qty'];
    if ($barang<1 || $qty<1) $pesan="Pilih barang dan qty minimal 1.";
    else  {
        $cek=mysqli_query($koneksi,"SELECT id FROM barang WHERE id=$barang");
        $duplikat=mysqli_query($koneksi,"SELECT barang_id FROM transaksi_detail WHERE transaksi_id=$id AND barang_id=$barang");
        if (!mysqli_num_rows($cek)) $pesan="Barang tidak ditemukan.";
        elseif (mysqli_num_rows($duplikat)) $pesan="Barang sudah ada pada transaksi ini.";
        else  {
            $qb=mysqli_query($koneksi,"SELECT harga FROM barang WHERE id=$barang");
            $harga=(int)mysqli_fetch_assoc($qb)['harga'];
            $stmt=mysqli_prepare($koneksi,"INSERT INTO transaksi_detail(transaksi_id,barang_id,harga,qty) VALUES(?,?,?,?)");
            mysqli_stmt_bind_param($stmt,"iiii",$id,$barang,$harga,$qty);
            mysqli_stmt_execute($stmt);
            $sum=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COALESCE(SUM(harga*qty),0) total FROM transaksi_detail WHERE transaksi_id=$id"));
            $total=(int)$sum['total'];
            mysqli_query($koneksi,"UPDATE transaksi SET total=$total WHERE id=$id");
            $pesan="Detail berhasil disimpan.";
        }
    }
}
$m=mysqli_query($koneksi,"SELECT t.*,p.nama FROM transaksi t LEFT JOIN pelanggan p ON t.pelanggan_id=p.id WHERE t.id=$id");
$master=mysqli_fetch_assoc($m);
if(!$master) die("Transaksi tidak ditemukan.");
awal_halaman("Detail Transaksi", "Transaksi");
echo '<p><a href="index.php">Kembali ke daftar transaksi</a></p>';
if($pesan) echo '<p class="pesan">'.e($pesan).'</p>';
echo '<table border="1"><tr><th>ID Transaksi</th><td>'.e($master['id']).'</td></tr><tr><th>Tanggal</th><td>'.e($master['waktu_transaksi']).'</td></tr><tr><th>Pelanggan</th><td>'.e($master['nama']).'</td></tr><tr><th>Keterangan</th><td>'.e($master['keterangan']).'</td></tr><tr><th>Total</th><td>Rp '.number_format($master['total'],0,',','.').'</td></tr></table>';
?>
<h3>Barang dalam Transaksi</h3><table border="1"><tr><th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
<?php $q=mysqli_query($koneksi,"SELECT b.kode_barang,b.nama_barang,d.harga,d.qty FROM transaksi_detail d JOIN barang b ON d.barang_id=b.id WHERE d.transaksi_id=$id");
$no=1;
while($r=mysqli_fetch_assoc($q)) {
    $sub=$r['harga']*$r['qty'];
    echo '<tr><td>'.$no++.'</td><td>'.e($r['kode_barang']).'</td><td>'.e($r['nama_barang']).'</td><td>'.number_format($r['harga'],0,',','.').'</td><td>'.e($r['qty']).'</td><td>'.number_format($sub,0,',','.').'</td></tr>';
}
?>
</table>
<h3>Tambah Barang ke Transaksi</h3><form method="post"><table>
<tr><td>Barang</td><td><select name="barang_id" required><option value="">-- Pilih Barang --</option>
<?php $q=mysqli_query($koneksi,"SELECT id,kode_barang,nama_barang,harga FROM barang WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id=$id)");
while($b=mysqli_fetch_assoc($q)) echo '<option value="'.$b['id'].'">'.e($b['kode_barang'].' - '.$b['nama_barang']).' (Rp '.number_format($b['harga'],0,',','.').')</option>';
?>
</select></td></tr><tr><td>Qty</td><td><input type="number" name="qty" min="1" value="1" required></td></tr><tr><td></td><td><input type="submit" name="simpan_detail" value="Simpan Detail"></td></tr>
</table></form>
<?php akhir_halaman();
?>
