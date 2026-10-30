<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO supplier (nama, telp, alamat)
              VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil ditambahkan!');
                window.location='index.php';
              </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
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

<div class="container">
    <h2>Tambah Data Master Supplier Baru</h2>
    <hr>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama"
                   placeholder="Nama" required>
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp"
                   placeholder="Telp" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat"
                   placeholder="Alamat" required>
        </div>

        <div class="form-button">
            <button type="submit" name="simpan"
                    class="btn simpan">Simpan</button>

            <a href="index.php" class="btn hapus">
                Batal
            </a>
        </div>
    </form>
</div>

</body>
</html>