<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: data_baru.php");
    exit;
}

$id = (int) $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM master_suppiler WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data suppiler tidak ditemukan.");
}

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['Nama']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['Telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['Alamat']);

    $update = mysqli_query($koneksi, "UPDATE master_suppiler SET
              Nama='$nama',
              Telp='$telp',
              Alamat='$alamat'
              WHERE id=$id");

    if ($update) {
        header("Location: data_baru.php");
        exit;
    } else {
        echo "Gagal mengubah data: " . mysqli_error($koneksi);
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
            margin: 25px;
            color: #555;
        }

        h2 {
            color: #39758d;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        .form {
            width: 500px;
            margin: 30px auto;
        }

        .baris {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        label {
            width: 130px;
            text-align: right;
            margin-right: 20px;
            font-weight: bold;
        }

        input {
            width: 270px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .update {
            margin-left: 150px;
            background: #75ad43;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .batal {
            background: #c82333;
            color: white;
            padding: 9px 15px;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<h2>Edit Data Master Supplier</h2>

<form method="POST" class="form">

    <div class="baris">
        <label>Nama</label>
        <input type="text" name="Nama" 
            placeholder="Nama"
               value="<?php echo htmlspecialchars($data['Nama']); ?>" required>
    </div>

    <div class="baris">
        <label>Telp</label>
        <input type="text" name="Telp" 
            placeholder="Telp"
               value="<?php echo htmlspecialchars($data['Telp']); ?>" required>
    </div>

    <div class="baris">
        <label>Alamat</label>
        <input type="text" name="Alamat" 
                placeholder="Alamat"
               value="<?php echo htmlspecialchars($data['Alamat']); ?>" required>
    </div>

    <button type="submit" name="update" class="update">Update</button>
    <a href="data_baru.php" class="batal">Batal</a>

</form>

</body>
</html>
