<?php
require_once 'auth.php';
require_owner();
include "koneksi.php";
$pesan = "";
$id_edit = "";
$data_edit = array("id" => "", "nama" => "", "jenis_kelamin" => "L", "telp" => "", "alamat" => "");

if (isset($_POST['simpan'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jk = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $id_lama = mysqli_real_escape_string($conn, $_POST['id_lama']);
    if ($id_lama != "") {
        $query = "UPDATE pelanggan SET id='$id', nama='$nama', jenis_kelamin='$jk', telp='$telp', alamat='$alamat' WHERE id='$id_lama'";
        $pesan = mysqli_query($conn, $query) ? "Data pelanggan berhasil diubah." : "Data pelanggan gagal diubah.";
    } else {
        $query = "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES ('$id', '$nama', '$jk', '$telp', '$alamat')";
        $pesan = mysqli_query($conn, $query) ? "Data pelanggan berhasil ditambahkan." : "Data pelanggan gagal ditambahkan.";
    }
}
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    $cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE pelanggan_id='$id'");
    if (mysqli_num_rows($cek) > 0) $pesan = "Pelanggan masih digunakan dalam transaksi.";
    else $pesan = mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'") ? "Data pelanggan berhasil dihapus." : "Data pelanggan gagal dihapus.";
}
if (isset($_GET['edit'])) {
    $id_edit = mysqli_real_escape_string($conn, $_GET['edit']);
    $hasil = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id='$id_edit'");
    if (mysqli_num_rows($hasil) > 0) $data_edit = mysqli_fetch_assoc($hasil);
}
$query = mysqli_query($conn, "SELECT * FROM pelanggan");
?>
<!DOCTYPE html><html><head><title>Data Pelanggan</title><style>
body{font-family:Arial;background:whitesmoke;margin:30px;color:darkslategray}h2{color:cadetblue}.app-nav{display:flex;align-items:center;flex-wrap:wrap;gap:5px;margin-bottom:20px}.app-nav a,.logout-form input{background:cadetblue;color:white;text-decoration:none;padding:9px 12px;border:0;border-radius:5px;cursor:pointer}.dropdown{position:relative}.dropdown-content{display:none;position:absolute;background:white;min-width:150px;z-index:1}.dropdown-content a{display:block}.dropdown:hover .dropdown-content{display:block}.user-info{margin:5px 10px}.logout-form{margin:0}table{width:100%;border-collapse:collapse;background:white;margin-top:15px}th{background:lightblue}th,td{border:1px solid lightgray;padding:9px}input,select{padding:8px;margin:5px}.pesan{padding:10px;background:lightyellow}
</style></head><body>
<?php app_nav(); ?><h2>Data Pelanggan</h2>
<?php if ($pesan != "") echo "<p class='pesan'>$pesan</p>"; ?>
<h3><?php echo $id_edit != "" ? "Edit Pelanggan" : "Tambah Pelanggan"; ?></h3>
<form method="POST"><input type="hidden" name="id_lama" value="<?php echo htmlspecialchars($id_edit); ?>"><input name="id" placeholder="ID Pelanggan" value="<?php echo htmlspecialchars($data_edit['id']); ?>" required><input name="nama" placeholder="Nama Pelanggan" value="<?php echo htmlspecialchars($data_edit['nama']); ?>" required><select name="jenis_kelamin"><option value="L" <?php if ($data_edit['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option><option value="P" <?php if ($data_edit['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option></select><input name="telp" placeholder="Telepon" value="<?php echo htmlspecialchars($data_edit['telp']); ?>"><input name="alamat" placeholder="Alamat" value="<?php echo htmlspecialchars($data_edit['alamat']); ?>"><input type="submit" name="simpan" value="Simpan"><?php if ($id_edit != "") { ?><a href="pelanggan.php">Batal</a><?php } ?></form>
<table><tr><th>ID</th><th>Nama Pelanggan</th><th>Jenis Kelamin</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr>
<?php while ($data = mysqli_fetch_assoc($query)) { ?><tr><td><?php echo htmlspecialchars($data['id']); ?></td><td><?php echo htmlspecialchars($data['nama']); ?></td><td><?php echo $data['jenis_kelamin']; ?></td><td><?php echo htmlspecialchars($data['telp']); ?></td><td><?php echo htmlspecialchars($data['alamat']); ?></td><td><a href="pelanggan.php?edit=<?php echo urlencode($data['id']); ?>">Edit</a> <a href="pelanggan.php?hapus=<?php echo urlencode($data['id']); ?>" onclick="return confirm('Hapus pelanggan ini?')">Hapus</a></td></tr><?php } ?></table>
</body></html>
