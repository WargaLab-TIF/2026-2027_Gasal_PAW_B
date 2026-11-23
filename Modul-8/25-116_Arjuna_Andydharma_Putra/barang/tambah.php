<?php
include '../koneksi.php';
cek_login();
if ($_SESSION['level'] != 1) {
    echo "<script>alert('Akses ditolak!'); window.location='../index.php';</script>";
    exit;
}

$supplier = mysqli_query($conn, "SELECT * FROM supplier ORDER BY nama");

if (isset($_POST['simpan'])) {
    $kode = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $supplier_id = (int)$_POST['supplier_id'];

    $q = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) 
          VALUES ('$kode', '$nama', $harga, $stok, $supplier_id)";
    if (mysqli_query($conn, $q)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal simpan: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f6fa; }
        .container { padding: 20px 30px; max-width: 500px; }
        form { background: white; padding: 25px; border-radius: 8px; }
        label { display: block; margin-top: 12px; font-size: 14px; }
        input, select { width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; color: #3498db; }
        .error { color: red; }
    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container">
        <h2>Tambah Data Barang</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" required>
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" required>
            <label>Harga</label>
            <input type="number" name="harga" required min="0">
            <label>Stok</label>
            <input type="number" name="stok" required min="0">
            <label>Supplier</label>
            <select name="supplier_id" required>
                <option value="">-- pilih --</option>
                <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
                <?php } ?>
            </select>
            <button type="submit" name="simpan">Simpan</button>
        </form>
        <a href="index.php">← Kembali</a>
    </div>
</body>
</html>
