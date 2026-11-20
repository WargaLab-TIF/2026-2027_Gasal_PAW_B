<?php
require_once "auth.php";
wajib_owner();
if(isset($_POST['simpan']))  {
    $id=(int)($_POST['id']??0);
    $nama=trim($_POST['nama']);
    $telp=trim($_POST['telp']);
    $alamat=trim($_POST['alamat']);
    if($id) {
        $s=mysqli_prepare($koneksi,"UPDATE supplier SET nama=?,telp=?,alamat=? WHERE id=?");
        mysqli_stmt_bind_param($s,"sssi",$nama,$telp,$alamat,$id);
    } else {
        $s=mysqli_prepare($koneksi,"INSERT INTO supplier(nama,telp,alamat) VALUES(?,?,?)");
        mysqli_stmt_bind_param($s,"sss",$nama,$telp,$alamat);
    }
    mysqli_stmt_execute($s);
    header("Location: supplier.php");
    exit;
}
if(isset($_GET['hapus']))  {
    $id=(int)$_GET['hapus'];
    $c=mysqli_query($koneksi,"SELECT COUNT(*) n FROM barang WHERE supplier_id=$id");
    if((int)mysqli_fetch_assoc($c)['n']===0) mysqli_query($koneksi,"DELETE FROM supplier WHERE id=$id");
}
$edit=null;
if(isset($_GET['edit'])) {
    $id=(int)$_GET['edit'];
    $edit=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM supplier WHERE id=$id"));
}
awal_halaman("Data Supplier","Data Master");
?>
<h3><?= $edit?'Edit':'Tambah' ?> Supplier</h3><form method="post"><input type="hidden" name="id" value="<?= e($edit['id']??'') ?>"><table>
<tr><td>Nama</td><td><input name="nama" value="<?= e($edit['nama']??'') ?>" required></td></tr><tr><td>Telepon</td><td><input name="telp" value="<?= e($edit['telp']??'') ?>"></td></tr><tr><td>Alamat</td><td><textarea name="alamat"><?= e($edit['alamat']??'') ?></textarea></td></tr><tr><td></td><td><input type="submit" name="simpan" value="Simpan"></td></tr></table></form>
<table border="1"><tr><th>ID</th><th>Nama</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr><?php $q=mysqli_query($koneksi,"SELECT * FROM supplier ORDER BY id");
while($r=mysqli_fetch_assoc($q))echo '<tr><td>'.$r['id'].'</td><td>'.e($r['nama']).'</td><td>'.e($r['telp']).'</td><td>'.e($r['alamat']).'</td><td><a href="supplier.php?edit='.$r['id'].'">Edit</a> | <a href="supplier.php?hapus='.$r['id'].'" onclick="return confirm(\'Hapus supplier?\')">Hapus</a></td></tr>';
?></table>
<?php akhir_halaman();
?>
