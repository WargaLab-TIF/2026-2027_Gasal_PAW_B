<?php
include 'koneksi.php';

if (isset($_POST['update'])) {
    $id = (int) $_POST["id"];
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];

    $sql = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id";

    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil diubah<br><br>";
        echo "<a href='tampil.php'><button>Kembali</button></a><br><br>";
        exit;
    } else {
        echo "Data gagal diubah: " . mysqli_error($koneksi);
    }
}


$id = (int) $_GET["id"];
$hasil = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id=$id");
$row = mysqli_fetch_assoc($hasil);

if (!$row) {
    die("Data tidak ditemukan");
}
?>
<h2>Edit DATA</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    Nama:
    <input type="text" name="nama" value="<?php echo $row['nama']; ?>"><br><br>
    Telp:
    <input type="text" name="telp" value="<?php echo $row['telp']; ?>"><br><br>
    Alamat:
    <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>"><br><br>
    <button type="submit" name="update">Update</button>
    <a href="tampil.php"><button type="button">Batal</button></a>
</form>