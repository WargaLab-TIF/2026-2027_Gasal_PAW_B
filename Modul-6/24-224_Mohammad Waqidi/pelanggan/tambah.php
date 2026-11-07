<?php 
require_once "../koneksi.php"; 
$judul = "Tambah pelanggan"; 
include "../header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    
    $types = "sssss";
    $values = [];
    $values[] = $_POST["id"] ?? "";
    $values[] = $_POST["nama"] ?? "";
    $values[] = $_POST["jenis_kelamin"] ?? "";
    $values[] = $_POST["telp"] ?? "";
    $values[] = $_POST["alamat"] ?? "";
    
    mysqli_stmt_bind_param($stmt, $types, ...$values);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } 
    
    $error = mysqli_stmt_error($stmt);
} 
?>

<h2>Tambah pelanggan</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>ID Pelanggan</label>
    <input name="id" type="text" required>
    
    <label>Nama</label>
    <input name="nama" type="text" required>
    
    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin">
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>
    
    <label>Telepon</label>
    <input name="telp" type="text" required>
    
    <label>Alamat</label>
    <textarea name="alamat" required></textarea>
    
    <button class="btn">Simpan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>