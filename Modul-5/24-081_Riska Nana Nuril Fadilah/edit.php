<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID supplier tidak ditemukan!");
}

$query = "SELECT * FROM supplier WHERE id='$id'";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data supplier tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE supplier SET
              nama='$nama',
              telp='$telp',
              alamat='$alamat'
              WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: tampilan.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Master Supplier</title>

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
            background-color: #5cb85c;
        }

        .batal {
            background-color: #c9302c;
        }
    </style>
</head>

<body>

    <h2>Edit Data Master Supplier</h2>

    <form method="POST">
        <label>Nama</label>
        <input type="text" name="nama"
        value="<?php echo htmlspecialchars($data['nama']); ?>" required>
        <br>

        <label>Telp</label>
        <input type="text" name="telp"
        value="<?php echo htmlspecialchars($data['telp']); ?>" required>
        <br>

        <label>Alamat</label>
        <input type="text" name="alamat"
        value="<?php echo htmlspecialchars($data['alamat']); ?>" required>
        <br>

        <button type="submit" name="update" class="update">
            Update
        </button>

        <a href="index.php" class="batal">Batal</a>
    </form>

</body>
</html>