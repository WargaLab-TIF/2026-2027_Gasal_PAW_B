<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_supplier";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil data berdasarkan id
$id = $_GET['id'];
$sql = "SELECT * FROM supplier WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Proses update data
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
        header("Location: index.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Master Supplier</title>
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
        .btn-update {
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

<h2>Edit Data Master Supplier</h2>

<form method="POST" action="">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required>
    </div>
    <div class="form-group">
        <label>Telp</label>
        <input type="text" name="telp" value="<?php echo $row['telp']; ?>" required>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" required>
    </div>
    <br>
    <button type="submit" name="update" class="btn-update">Update</button>
    <a href="index.php" class="btn-batal">Batal</a>
</form>

</body>
</html>
<?php mysqli_close($conn); ?>
