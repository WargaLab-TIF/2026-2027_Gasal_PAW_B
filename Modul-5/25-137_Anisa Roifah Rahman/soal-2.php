<?php
include "koneksi.php";

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO supplier (nama, telp, alamat)
              VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $query)) {
        header("Location: soal-1.php");
        exit;
    } else {
        $pesan = "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container form-container">
    <h2 class="form-title">Tambah Data Master Supplier</h2>

    <?php
    if ($pesan != "") {
        echo "<p class='message'>$pesan</p>";
    }
    ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nama Supplier</label>
            <input type="text" name="nama" required>
        </div>

        <div class="form-group">
            <label>Telepon</label>
            <input type="text" name="telp" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                Simpan
            </button>

            <a href="soal-1.php" class="btn btn-danger">
                Batal
            </a>
        </div>
    </form>
</div>
</body>
</html>