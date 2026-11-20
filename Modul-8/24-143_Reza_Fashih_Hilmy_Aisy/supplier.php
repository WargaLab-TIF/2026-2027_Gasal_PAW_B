<?php
require_once 'auth.php';
require_owner();
include "koneksi.php";
$pesan = "";
$id_edit = 0;
$data_edit = array("nama" => "", "telp" => "", "alamat" => "");

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $id = (int) $_POST['id'];
    if ($id > 0) {
        $query = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id";
        $pesan = mysqli_query($conn, $query) ? "Data supplier berhasil diubah." : "Data supplier gagal diubah.";
    } else {
        $query = "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')";
        $pesan = mysqli_query($conn, $query) ? "Data supplier berhasil ditambahkan." : "Data supplier gagal ditambahkan.";
    }
}
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $cek = mysqli_query($conn, "SELECT * FROM barang WHERE supplier_id=$id");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Supplier masih digunakan oleh data barang.";
    } else {
        $pesan = mysqli_query($conn, "DELETE FROM supplier WHERE id=$id") ? "Data supplier berhasil dihapus." : "Data supplier gagal dihapus.";
    }
}
if (isset($_GET['edit'])) {
    $id_edit = (int) $_GET['edit'];
    $hasil = mysqli_query($conn, "SELECT * FROM supplier WHERE id=$id_edit");
    if (mysqli_num_rows($hasil) > 0) $data_edit = mysqli_fetch_assoc($hasil);
}
$query = mysqli_query($conn, "SELECT * FROM supplier");
?>
<!DOCTYPE html><html><head><title>Data Supplier</title><style>
body{font-family:Arial;background:whitesmoke;margin:30px;color:darkslategray}h2{color:cadetblue}.app-nav{display:flex;align-items:center;flex-wrap:wrap;gap:5px;margin-bottom:20px}.app-nav a,.logout-form input{background:cadetblue;color:white;text-decoration:none;padding:9px 12px;border:0;border-radius:5px;cursor:pointer}.dropdown{position:relative}.dropdown-content{display:none;position:absolute;background:white;min-width:150px;z-index:1}.dropdown-content a{display:block}.dropdown:hover .dropdown-content{display:block}.user-info{margin:5px 10px}.logout-form{margin:0}table{width:100%;border-collapse:collapse;background:white;margin-top:15px}th{background:lightblue}th,td{border:1px solid lightgray;padding:9px}input{padding:8px;margin:5px}.pesan{padding:10px;background:lightyellow}
</style></head><body>
<?php app_nav(); ?><h2>Data Supplier</h2>
<?php if ($pesan != "") echo "<p class='pesan'>$pesan</p>"; ?>
<h3><?php echo $id_edit > 0 ? "Edit Supplier" : "Tambah Supplier"; ?></h3>
<form method="POST"><input type="hidden" name="id" value="<?php echo $id_edit; ?>"><input name="nama" placeholder="Nama Supplier" value="<?php echo htmlspecialchars($data_edit['nama']); ?>" required><input name="telp" placeholder="Telepon" value="<?php echo htmlspecialchars($data_edit['telp']); ?>"><input name="alamat" placeholder="Alamat" value="<?php echo htmlspecialchars($data_edit['alamat']); ?>"><input type="submit" name="simpan" value="Simpan"><?php if ($id_edit > 0) { ?><a href="supplier.php">Batal</a><?php } ?></form>
<table><tr><th>ID</th><th>Nama Supplier</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr>
<?php while ($data = mysqli_fetch_assoc($query)) { ?><tr><td><?php echo $data['id']; ?></td><td><?php echo htmlspecialchars($data['nama']); ?></td><td><?php echo htmlspecialchars($data['telp']); ?></td><td><?php echo htmlspecialchars($data['alamat']); ?></td><td><a href="supplier.php?edit=<?php echo $data['id']; ?>">Edit</a> <a href="supplier.php?hapus=<?php echo $data['id']; ?>" onclick="return confirm('Hapus supplier ini?')">Hapus</a></td></tr><?php } ?></table>
</body></html>
