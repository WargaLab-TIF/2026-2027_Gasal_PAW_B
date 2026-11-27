<?php
require 'koneksi.php';
include 'midlewire.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID pelanggan tidak ditemukan!");
}

$query = "SELECT * FROM pelanggan WHERE id='$id'";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data pelanggan tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE pelanggan SET
              nama='$nama',
              jenis_kelamin='$jenis_kelamin',
              telp='$telp',
              alamat='$alamat'
              WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: pelanggan.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Master Pelanggan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h2 {
            color: #5b9aaa;
        }

        label {
            display: inline-block;
            width: 120px;
            margin-bottom: 15px;
        }

        input, select {
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
            background-color: #5cb85c;
        }

        .batal {
            background-color: #c9302c;
        }
    </style>
</head>

<body>

    <h2>Edit Data Master Pelanggan</h2>

    <form method="POST">

        <label>ID Pelanggan</label>
        <input type="text" value="<?php echo htmlspecialchars($data['id']); ?>" readonly>
        <br>

        <label>Nama</label>
        <input type="text" name="nama"
        value="<?php echo htmlspecialchars($data['nama']); ?>" required>
        <br>

        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="L" <?php if ($data['jenis_kelamin'] == 'L') echo 'selected'; ?>>
                Laki-laki
            </option>
            <option value="P" <?php if ($data['jenis_kelamin'] == 'P') echo 'selected'; ?>>
                Perempuan
            </option>
        </select>
        <br>

        <label>Telepon</label>
        <input type="text" name="telp"
        value="<?php echo htmlspecialchars($data['telp']); ?>" required>
        <br>

        <label>Alamat</label>
        <input type="text" name="alamat"
        value="<?php echo htmlspecialchars($data['alamat']); ?>" required>
        <br><br>

        <button type="submit" name="update" class="update">
            Update
        </button>

        <a href="pelanggan.php" class="batal">Batal</a>

    </form>

</body>
</html>