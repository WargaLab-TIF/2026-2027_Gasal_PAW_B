<?php
require_once "auth.php";
wajib_owner();
if(isset($_POST['simpan']))  {
    $id=trim($_POST['id']);
    $nama=trim($_POST['nama']);
    $jk=$_POST['jenis_kelamin'];
    $telp=trim($_POST['telp']);
    $alamat=trim($_POST['alamat']);
    if(isset($_POST['mode_edit'])&&$_POST['mode_edit']==='1') {
        $s=mysqli_prepare($koneksi,"UPDATE pelanggan SET nama=?,jenis_kelamin=?,telp=?,alamat=? WHERE id=?");
        mysqli_stmt_bind_param($s,"sssss",$nama,$jk,$telp,$alamat,$id);
    } else {
        $s=mysqli_prepare($koneksi,"INSERT INTO pelanggan(id,nama,jenis_kelamin,telp,alamat) VALUES(?,?,?,?,?)");
        mysqli_stmt_bind_param($s,"sssss",$id,$nama,$jk,$telp,$alamat);
    }
    mysqli_stmt_execute($s);
    header("Location: pelanggan.php");
    exit;
}
if(isset($_GET['hapus'])) {
    $id=mysqli_real_escape_string($koneksi,$_GET['hapus']);
    $c=mysqli_query($koneksi,"SELECT COUNT(*) n FROM transaksi WHERE pelanggan_id='$id'");
    if((int)mysqli_fetch_assoc($c)['n']===0)mysqli_query($koneksi,"DELETE FROM pelanggan WHERE id='$id'");
}
$edit=null;
if(isset($_GET['edit'])) {
    $id=mysqli_real_escape_string($koneksi,$_GET['edit']);
    $edit=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM pelanggan WHERE id='$id'"));
}
awal_halaman("Data Pelanggan","Data Master");
?>
<h3><?= $edit?'Edit':'Tambah' ?> Pelanggan</h3><form method="post"><input type="hidden" name="mode_edit" value="<?= $edit?'1':'0' ?>"><table>
<tr><td>ID Pelanggan</td><td><input name="id" value="<?= e($edit['id']??'') ?>" <?= $edit?'readonly':'' ?> required></td></tr><tr><td>Nama</td><td><input name="nama" value="<?= e($edit['nama']??'') ?>" required></td></tr><tr><td>Jenis Kelamin</td><td><select name="jenis_kelamin"><option value="L" <?= (($edit['jenis_kelamin']??'')==='L')?'selected':'' ?>>Laki-laki</option><option value="P" <?= (($edit['jenis_kelamin']??'')==='P')?'selected':'' ?>>Perempuan</option></select></td></tr><tr><td>Telepon</td><td><input name="telp" value="<?= e($edit['telp']??'') ?>"></td></tr><tr><td>Alamat</td><td><textarea name="alamat"><?= e($edit['alamat']??'') ?></textarea></td></tr><tr><td></td><td><input type="submit" name="simpan" value="Simpan"></td></tr></table></form>
<table border="1"><tr><th>ID</th><th>Nama</th><th>JK</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr><?php $q=mysqli_query($koneksi,"SELECT * FROM pelanggan ORDER BY id");
while($r=mysqli_fetch_assoc($q))echo '<tr><td>'.e($r['id']).'</td><td>'.e($r['nama']).'</td><td>'.e($r['jenis_kelamin']).'</td><td>'.e($r['telp']).'</td><td>'.e($r['alamat']).'</td><td><a href="pelanggan.php?edit='.urlencode($r['id']).'">Edit</a> | <a href="pelanggan.php?hapus='.urlencode($r['id']).'" onclick="return confirm(\'Hapus pelanggan?\')">Hapus</a></td></tr>';
?></table>
<?php akhir_halaman();
?>
