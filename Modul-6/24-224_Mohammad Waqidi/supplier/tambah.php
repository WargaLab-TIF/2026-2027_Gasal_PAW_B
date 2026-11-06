<?php 
require_once "../koneksi.php"; 
$judul = "Tambah supplier"; 
include "../header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    
    $types = "sss";
    $values = [];
    $values[] = $_POST["nama"] ?? "";
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

<h2>Tambah supplier</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>Nama</label>
    <input name="nama" type="text" required>
    
    <label>Telepon</label>
    <input name="telp" type="text" required>
    
    <label>Alamat</label>
    <textarea name="alamat" required></textarea>
    
    <button class="btn">Simpan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>