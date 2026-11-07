<?php 
require_once "../koneksi.php";
$judul = "Tambah Barang";
include "../header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $sid = (int)$_POST['supplier_id'];
    
    $st = mysqli_prepare(
        $koneksi, 
        "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES (?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($st, "ssiii", $kode, $nama, $harga, $stok, $sid);
    
    if (mysqli_stmt_execute($st)) {
        header("Location: index.php");
        exit;
    }
    
    $error = mysqli_error($koneksi);
}

$s = mysqli_query($koneksi, "SELECT id, nama FROM supplier ORDER BY nama");
?>

<h2>Tambah Barang</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>Kode Barang</label>
    <input name="kode_barang" required>
    
    <label>Nama Barang</label>
    <input name="nama_barang" required>
    
    <label>Harga</label>
    <input name="harga" type="number" min="0" required>
    
    <label>Stok</label>
    <input name="stok" type="number" min="0" required>
    
    <label>Supplier</label>
    <select name="supplier_id">
        <option value="">-- Pilih supplier --</option>
        <?php while ($x = mysqli_fetch_assoc($s)) { ?>
            <option value="<?= $x['id'] ?>"><?= htmlspecialchars($x['nama']) ?></option>
        <?php } ?>
    </select>
    
    <button class="btn">Simpan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>