<?php
require_once "auth.php";
wajib_owner();
$pesan="";
if(isset($_POST['simpan']))  {
    $id=(int)($_POST['id_user']??0);
    $username=trim($_POST['username']);
    $nama=trim($_POST['nama']);
    $alamat=trim($_POST['alamat']);
    $hp=trim($_POST['hp']);
    $level=(int)$_POST['level'];
    $password=$_POST['password']??'';
    if($id)  {
        if($password!=="")  {
            $hash=md5($password);
            $s=mysqli_prepare($koneksi,"UPDATE user SET username=?,password=?,nama=?,alamat=?,hp=?,level=? WHERE id_user=?");
            mysqli_stmt_bind_param($s,"sssssii",$username,$hash,$nama,$alamat,$hp,$level,$id);
        }
        else  {
            $s=mysqli_prepare($koneksi,"UPDATE user SET username=?,nama=?,alamat=?,hp=?,level=? WHERE id_user=?");
            mysqli_stmt_bind_param($s,"ssssii",$username,$nama,$alamat,$hp,$level,$id);
        }
    }  else  {
        $hash=md5($password);
        $s=mysqli_prepare($koneksi,"INSERT INTO user(username,password,nama,alamat,hp,level) VALUES(?,?,?,?,?,?)");
        mysqli_stmt_bind_param($s,"sssssi",$username,$hash,$nama,$alamat,$hp,$level);
    }
    if($password!==""||$id)  {
        if(!mysqli_stmt_execute($s))$pesan="Gagal menyimpan. Periksa username agar tidak sama.";
        else  {
            header("Location: user.php");
            exit;
        }
    }
}
if(isset($_GET['hapus']))  {
    $id=(int)$_GET['hapus'];
    if($id!==(int)$_SESSION['id_user'])mysqli_query($koneksi,"DELETE FROM user WHERE id_user=$id");
}
$edit=null;
if(isset($_GET['edit'])) {
    $id=(int)$_GET['edit'];
    $edit=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM user WHERE id_user=$id"));
}
awal_halaman("Data User","Data Master");
if($pesan)echo '<p class="pesan">'.e($pesan).'</p>';
?>
<h3><?= $edit?'Edit':'Tambah' ?> User</h3><form method="post"><input type="hidden" name="id_user" value="<?= e($edit['id_user']??'') ?>"><table>
<tr><td>Username</td><td><input name="username" value="<?= e($edit['username']??'') ?>" required></td></tr><tr><td>Password <?= $edit?'(kosongkan jika tidak diubah)':'' ?></td><td><input type="password" name="password" <?= $edit?'':'required' ?>></td></tr><tr><td>Nama</td><td><input name="nama" value="<?= e($edit['nama']??'') ?>" required></td></tr><tr><td>Alamat</td><td><input name="alamat" value="<?= e($edit['alamat']??'') ?>"></td></tr><tr><td>HP</td><td><input name="hp" value="<?= e($edit['hp']??'') ?>"></td></tr><tr><td>Level</td><td><select name="level"><option value="1" <?= (($edit['level']??1)==1)?'selected':'' ?>>1 - Owner</option><option value="2" <?= (($edit['level']??2)==2)?'selected':'' ?>>2 - Kasir</option></select></td></tr><tr><td></td><td><input type="submit" name="simpan" value="Simpan"></td></tr></table></form>
<table border="1"><tr><th>ID</th><th>Username</th><th>Nama</th><th>Level</th><th>Aksi</th></tr><?php $q=mysqli_query($koneksi,"SELECT * FROM user ORDER BY id_user");
while($r=mysqli_fetch_assoc($q))echo '<tr><td>'.$r['id_user'].'</td><td>'.e($r['username']).'</td><td>'.e($r['nama']).'</td><td>'.($r['level']==1?'Owner (1)':'Kasir (2)').'</td><td><a href="user.php?edit='.$r['id_user'].'">Edit</a> | '.($r['id_user']!=$_SESSION['id_user']?'<a href="user.php?hapus='.$r['id_user'].'" onclick="return confirm(\'Hapus user?\')">Hapus</a>':'User aktif').'</td></tr>';
?></table>
<?php akhir_halaman();
?>
