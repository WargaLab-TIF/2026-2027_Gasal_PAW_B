<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_supplier";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO supplier (nama, telp, alamat)
    VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Master Supplier Baru</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { color: #3498db; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 80px; }
        input[type=text] {
            padding: 6px;
            width: 250px;
            border: 1px solid #ccc;
        }
        .btn-simpan {
            background-color: #28a745;
            color: white;
            padding: 8px 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-batal {
            background-color: #c0392b;
            color: white;
            padding: 8px 18px;
            text-decoration: none;
            border-radius: 4px;
            margin-left: 5px;
        }
    </style>
</head>
<body>

<h2>Tambah Data Master Supplier Baru</h2>

<form method="POST" action="">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Nama" required>
    </div>
    <div class="form-group">
        <label>Telp</label>
        <input type="text" name="telp" placeholder="telp" required>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat" placeholder="alamat" required>
    </div>
    <br>
    <button type="submit" name="simpan" class="btn-simpan">Simpan</button>
    <a href="index.php" class="btn-batal">Batal</a>
</form>

</body>
</html>
<?php mysqli_close($conn); ?>
