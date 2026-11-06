<?php 
require_once "../koneksi.php"; 
$judul = "Tambah user"; 
include "../header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO user (id_user, username, password, nama, alamat, hp, level) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    
    $types = "isssssi";
    $values = [];
    $values[] = $_POST["id_user"] ?? "";
    $values[] = $_POST["username"] ?? "";
    $values[] = $_POST["password"] ?? "";
    $values[] = $_POST["nama"] ?? "";
    $values[] = $_POST["alamat"] ?? "";
    $values[] = $_POST["hp"] ?? "";
    $values[] = $_POST["level"] ?? "";
    
    mysqli_stmt_bind_param($stmt, $types, ...$values);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } 
    
    $error = mysqli_stmt_error($stmt);
} 
?>

<h2>Tambah user</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>ID User</label>
    <input name="id_user" type="number" required>
    
    <label>Username</label>
    <input name="username" type="text" required>
    
    <label>Password</label>
    <input name="password" type="text" required>
    
    <label>Nama</label>
    <input name="nama" type="text" required>
    
    <label>Alamat</label>
    <input name="alamat" type="text" required>
    
    <label>HP</label>
    <input name="hp" type="text" required>
    
    <label>Level</label>
    <input name="level" type="number" required>
    
    <button class="btn">Simpan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>