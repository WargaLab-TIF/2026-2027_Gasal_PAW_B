<?php
include "koneksi.php";

$id = (int) $_GET['id'];

$sql = "SELECT * FROM supplier WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan.");
}

if (isset($_POST['update'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $sql = "UPDATE supplier SET
            nama = '$nama',
            Telp = '$telp',
            Alamat = '$alamat'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal diubah: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Supplier</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            color: #555;
        }
        h2 {
            color: #43899b;
        }
        input {
            padding: 9px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button, a {
            padding: 9px 15px;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        button {
            background: #5cb85c;
        }
        a {
            background: #c9302c;
        }
    </style>
</head>
<body>
<h2>Edit Data Master Supplier</h2>
<form method="POST">
    <p>
        Nama
        <input type="text" name="nama"
               value="<?php echo htmlspecialchars($data['nama']); ?>"
               required>
    </p>
    <p>
        Telp
        <input type="text" name="telp"
               value="<?php echo htmlspecialchars($data['Telp']); ?>"
               required>
    </p>
    <p>
        Alamat
        <input type="text" name="alamat"
               value="<?php echo htmlspecialchars($data['Alamat']); ?>"
               required>
    </p>
    <button type="submit" name="update">Update</button>
    <a href="index.php">Batal</a>
</form>
</body>
</html>

<?php
mysqli_close($conn);
?>