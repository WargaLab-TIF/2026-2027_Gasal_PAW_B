<?php
include "koneksi.php";

$id = $_GET['id'];
$pesan = "";

$query = "SELECT * FROM supplier WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data supplier tidak ditemukan!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE supplier
              SET nama = '$nama',
                  telp = '$telp',
                  alamat = '$alamat'
              WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: soal-1.php");
        exit;
    } else {
        $pesan = "Gagal mengubah data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container form-container">
    <h2 class="form-title">Edit Data Master Supplier</h2>

    <?php
    if ($pesan != "") {
        echo "<p class='message'>$pesan</p>";
    }
    ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nama Supplier</label>
            <input type="text" name="nama"
                   value="<?php echo htmlspecialchars($data['nama']); ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Telepon</label>
            <input type="text" name="telp"
                   value="<?php echo htmlspecialchars($data['telp']); ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat"
                   value="<?php echo htmlspecialchars($data['alamat']); ?>"
                   required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                Update
            </button>

            <a href="soal-1.php" class="btn btn-danger">
                Batal
            </a>
        </div>
    </form>
</div>

</body>
</html>