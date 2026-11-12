<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM supplier WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data supplier tidak ditemukan");
}

if (isset($_POST['update'])) {

    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "UPDATE supplier SET
        nama='$nama',
        telp='$telp',
        alamat='$alamat'
        WHERE id='$id'");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal diupdate";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Supplier</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 30px;
    }

    h2 {
        color: cadetblue;
    }

    label {
        display: inline-block;
        width: 100px;
        margin-bottom: 15px;
    }

    input {
        padding: 8px;
        width: 200px;
    }

    button, a {
        padding: 8px 12px;
        color: white;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .update {
        background-color: mediumseagreen;
    }

    .batal {
        background-color: firebrick;
    }
</style>
</head>
<body>

<div class="container">

    <h2>Edit Data Master Supplier</h2>

    <form method="POST">

        <div class="form-group">
            <label>Nama</label>
            <input class="nama" type="text" name="nama"
            value="<?php echo htmlspecialchars($data['nama']); ?>" required>
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp"
            value="<?php echo htmlspecialchars($data['telp']); ?>" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat"
            value="<?php echo htmlspecialchars($data['alamat']); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class ="update" name="update">Update</button>
            <a href="index.php" class="batal">Batal</a>
        </div>

    </form>

</div>

</body>
</html>