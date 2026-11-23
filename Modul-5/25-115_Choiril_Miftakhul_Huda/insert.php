<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];

    $sql = "INSERT INTO supplier (nama, telp, alamat)
            VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil ditambahkan <br><br>";
        echo "<a href='tampil.php'><button>Kembali</button></a><br><br>";
        exit;
    } else {
        echo "Data gagal ditambahkan: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}
?>

<h2>Tambah DATA</h2>
<form method="POST">
    Nama: 
    <input type="text" name="nama"><br><br>
    Telp: 
    <input type="text" name="telp"><br><br>
    Alamat: 
    <input type="text" name="alamat"><br><br>
    <button type="submit" name="simpan">Simpan</button>
    <a href="tampil.php"><button type="button">Batal</button></a>
</form>