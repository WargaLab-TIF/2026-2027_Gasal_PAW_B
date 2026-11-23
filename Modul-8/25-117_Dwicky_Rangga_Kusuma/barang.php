<?php
require_once "auth.php";
wajib_owner();
$pesan="";
if(isset($_POST['simpan']))  {
    $id=(int)($_POST['id']??0);
    $kode=trim($_POST['kode_barang']);
    $nama=trim($_POST['nama_barang']);
    $harga=(int)$_POST['harga'];
    $stok=(int)$_POST['stok'];
    $supplier=(int)$_POST['supplier_id'];
    if($id)  {
        $st=mysqli_prepare($koneksi,"UPDATE barang SET kode_barang=?,nama_barang=?,harga=?,stok=?,supplier_id=? WHERE id=?");
        mysqli_stmt_bind_param($st,"ssiiii",$kode,$nama,$harga,$stok,$supplier,$id);
    }
    else  {
        $st=mysqli_prepare($koneksi,"INSERT INTO barang(kode_barang,nama_barang,harga,stok,supplier_id) VALUES(?,?,?,?,?)");
        mysqli_stmt_bind_param($st,"ssiii",$kode,$nama,$harga,$stok,$supplier);
    }
    mysqli_stmt_execute($st);
    header("Location: barang.php");
    exit;
}
if(isset($_GET['hapus']))  {
    $id=(int)$_GET['hapus'];
    $cek=mysqli_query($koneksi,"SELECT COUNT(*) n FROM transaksi_detail WHERE barang_id=$id");
    if((int)mysqli_fetch_assoc($cek)['n']===0) mysqli_query($koneksi,"DELETE FROM barang WHERE id=$id");
    else $pesan="Barang tidak dapat dihapus karena sudah digunakan pada transaksi.";
}
$edit=null;
if(isset($_GET['edit']))  {
    $id=(int)$_GET['edit'];
    $edit=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM barang WHERE id=$id"));
}
awal_halaman("Data Barang","Data Master");
if($pesan) echo '<p class="pesan">'.e($pesan).'</p>';
?>
<h3><?= $edit?'Edit':'Tambah' ?> Barang</h3><form method="post"><input type="hidden" name="id" value="<?= e($edit['id']??'') ?>"><table>
<tr><td>Kode Barang</td><td><input name="kode_barang" value="<?= e($edit['kode_barang']??'') ?>" required></td></tr>
<tr><td>Nama Barang</td><td><input name="nama_barang" value="<?= e($edit['nama_barang']??'') ?>" required></td></tr>
<tr><td>Harga</td><td><input type="number" name="harga" min="0" value="<?= e($edit['harga']??'') ?>" required></td></tr>
<tr><td>Stok</td><td><input type="number" name="stok" min="0" value="<?= e($edit['stok']??'') ?>" required></td></tr>
<tr><td>Supplier</td><td><select name="supplier_id" required><option value="">-- Pilih Supplier --</option><?php $s=mysqli_query($koneksi,"SELECT id,nama FROM supplier");
while($r=mysqli_fetch_assoc($s)) {
    $sel=(($edit['supplier_id']??'')==$r['id'])?'selected':'';
    echo '<option value="'.$r['id'].'" '.$sel.'>'.e($r['nama']).'</option>';
}
?></select></td></tr>
<tr><td></td><td><input type="submit" name="simpan" value="Simpan"></td></tr></table></form>
<h3>Daftar Barang</h3><table border="1"><tr><th>ID</th><th>Kode</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Supplier</th><th>Aksi</th></tr>
<?php $q=mysqli_query($koneksi,"SELECT b.*,s.nama supplier FROM barang b LEFT JOIN supplier s ON b.supplier_id=s.id ORDER BY b.id");
while($r=mysqli_fetch_assoc($q)) echo '<tr><td>'.$r['id'].'</td><td>'.e($r['kode_barang']).'</td><td>'.e($r['nama_barang']).'</td><td>'.number_format($r['harga'],0,',','.').'</td><td>'.$r['stok'].'</td><td>'.e($r['supplier']).'</td><td><a href="barang.php?edit='.$r['id'].'">Edit</a> | <a href="barang.php?hapus='.$r['id'].'" onclick="return confirm(\'Hapus barang?\')">Hapus</a></td></tr>';
?>
</table><?php akhir_halaman();
?>
