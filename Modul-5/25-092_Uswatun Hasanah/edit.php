<?php
include 'koneksi.php';
mysqli_select_db($conn, "modul5");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM supplier WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE supplier SET 
    nama='$nama', 
    telp='$telp', 
    alamat='$alamat' 
    WHERE id=$id";

     if (mysqli_query($conn, $query)) {
        header("Location: index.php");
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
            color: #333;
        }

        h2 {
            color: #5790a5;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }

        input {
            width: 350px;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            padding: 9px 13px;
            border: none;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
        }

        .update {
            background-color: #70ad47;
        }

        .batal {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <h2>Edit Data Master Supplier</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= $row['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp" value="<?= $row['telp']; ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="<?= $row['alamat']; ?>" required>
        </div>
        <button type="submit" name="update" class="btn update">Update</button>
        <a href="index.php" class="btn batal">Batal</a>
    </form>

</body>
</html>