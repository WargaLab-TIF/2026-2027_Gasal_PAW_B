<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $telpon = $_POST['telpon'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO suplier (nama, telpon, alamat)
            VALUES ('$nama', '$telpon', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal ditambahkan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Supplier</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f1f5f9;
            color: #334155;
        }
        .container {
            width: 450px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
        }
        h2 { color: #256da8; }
        input {
            width: 95%;
            padding: 9px;
            margin: 7px 0 15px;
            border: 1px solid #cbd5e1;
        }
        button, a {
            background-color: #256da8;
            color: white;
            padding: 9px 12px;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }
        a { background-color: #64748b; }
    </style>
</head>
<body>
<div class="container">
    <h2>Tambah Data Supplier</h2>

    <form method="POST">
        Nama:<br>
        <input type="text" name="nama" required>

        Telpon:<br>
        <input type="text" name="telpon" required>

        Alamat:<br>
        <input type="text" name="alamat" required>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>
</div>
</body>
</html>

<?php
mysqli_close($conn);
?>