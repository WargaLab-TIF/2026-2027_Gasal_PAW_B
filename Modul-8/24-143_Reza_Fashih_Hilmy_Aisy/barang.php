<?php
require_once 'auth.php';
require_owner();
include "koneksi.php";

$pesan = "";
$id_edit = 0;
$data_edit = array("kode_barang" => "", "nama_barang" => "", "harga" => "", "stok" => "", "supplier_id" => "");

if (isset($_POST['simpan'])) {
    $kode = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $supplier_id = (int) $_POST['supplier_id'];
    $id = (int) $_POST['id'];

    if ($id > 0) {
        $query = "UPDATE barang SET kode_barang='$kode', nama_barang='$nama', harga=$harga, stok=$stok, supplier_id=$supplier_id WHERE id=$id";
        $pesan = mysqli_query($conn, $query) ? "Data barang berhasil diubah." : "Data barang gagal diubah.";
    } else {
        $query = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES ('$kode', '$nama', $harga, $stok, $supplier_id)";
        $pesan = mysqli_query($conn, $query) ? "Data barang berhasil ditambahkan." : "Data barang gagal ditambahkan.";
    }
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id=$id");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Barang masih digunakan dalam transaksi.";
    } else {
        $hapus = mysqli_query($conn, "DELETE FROM barang WHERE id=$id");
        $pesan = $hapus ? "Data barang berhasil dihapus." : "Data barang gagal dihapus.";
    }
}

if (isset($_GET['edit'])) {
    $id_edit = (int) $_GET['edit'];
    $hasil_edit = mysqli_query($conn, "SELECT * FROM barang WHERE id=$id_edit");
    if (mysqli_num_rows($hasil_edit) > 0) {
        $data_edit = mysqli_fetch_assoc($hasil_edit);
    }
}

$query = mysqli_query($conn, "SELECT barang.*, supplier.nama AS nama_supplier FROM barang INNER JOIN supplier ON barang.supplier_id=supplier.id");
$supplier = mysqli_query($conn, "SELECT * FROM supplier");
?>
<!DOCTYPE html>
<html><head><title>Data Barang</title><style>
body{font-family:Arial;background:whitesmoke;margin:30px;color:darkslategray}h2{color:cadetblue}.app-nav{display:flex;align-items:center;flex-wrap:wrap;gap:5px;margin-bottom:20px}.app-nav a,.logout-form input{background:cadetblue;color:white;text-decoration:none;padding:9px 12px;border:0;border-radius:5px;cursor:pointer}.dropdown{position:relative}.dropdown-content{display:none;position:absolute;background:white;min-width:150px;z-index:1}.dropdown-content a{display:block}.dropdown:hover .dropdown-content{display:block}.user-info{margin:5px 10px}.logout-form{margin:0}table{width:100%;border-collapse:collapse;background:white;margin-top:15px}th{background:lightblue}th,td{border:1px solid lightgray;padding:9px;text-align:left}input,select{padding:8px;margin:5px}button{padding:8px 12px;cursor:pointer}.pesan{padding:10px;background:lightyellow}
</style></head><body>
<?php app_nav(); ?>
<h2>Data Barang</h2>
<?php if ($pesan != "") { echo "<p class='pesan'>$pesan</p>"; } ?>
<h3><?php echo $id_edit > 0 ? "Edit Barang" : "Tambah Barang"; ?></h3>
<form method="POST" action="">
<input type="hidden" name="id" value="<?php echo $id_edit; ?>">
<input type="text" name="kode_barang" placeholder="Kode Barang" value="<?php echo htmlspecialchars($data_edit['kode_barang']); ?>" required>
<input type="text" name="nama_barang" placeholder="Nama Barang" value="<?php echo htmlspecialchars($data_edit['nama_barang']); ?>" required>
<input type="number" name="harga" placeholder="Harga" value="<?php echo $data_edit['harga']; ?>" min="0" required>
<input type="number" name="stok" placeholder="Stok" value="<?php echo $data_edit['stok']; ?>" min="0" required>
<select name="supplier_id" required><option value="">Pilih Supplier</option>
<?php while ($s = mysqli_fetch_assoc($supplier)) { ?><option value="<?php echo $s['id']; ?>" <?php if ($data_edit['supplier_id'] == $s['id']) echo "selected"; ?>><?php echo htmlspecialchars($s['nama']); ?></option><?php } ?>
</select>
<input type="submit" name="simpan" value="Simpan">
<?php if ($id_edit > 0) { ?><a href="barang.php">Batal</a><?php } ?>
</form>
<h3>Daftar Barang</h3>
<table><tr><th>ID</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Supplier</th><th>Aksi</th></tr>
<?php while ($data = mysqli_fetch_assoc($query)) { ?>
<tr><td><?php echo $data['id']; ?></td><td><?php echo htmlspecialchars($data['kode_barang']); ?></td><td><?php echo htmlspecialchars($data['nama_barang']); ?></td><td><?php echo $data['harga']; ?></td><td><?php echo $data['stok']; ?></td><td><?php echo htmlspecialchars($data['nama_supplier']); ?></td><td><a href="barang.php?edit=<?php echo $data['id']; ?>">Edit</a> <a href="barang.php?hapus=<?php echo $data['id']; ?>" onclick="return confirm('Hapus barang ini?')">Hapus</a></td></tr>
<?php } ?></table>
</body></html>
