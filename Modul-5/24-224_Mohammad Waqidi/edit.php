<?php
include "koneksi.php";

$id = $_GET['id'];

$sql = "SELECT * FROM suplier WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telpon = $_POST['telpon'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE suplier SET
            nama = '$nama',
            telpon = '$telpon',
            alamat = '$alamat'
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal diperbarui: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f1f5f9;
            color: #334155;
        }
        .container {
            width: 450px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
        }
        h2 { color: #256da8; }
        input {
            width: 95%;
            padding: 9px;
            margin: 7px 0 15px;
            border: 1px solid #cbd5e1;
        }
        button, a {
            background-color: #256da8;
            color: white;
            padding: 9px 12px;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }
        a { background-color: #64748b; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Data Supplier</h2>

    <form method="POST">
        Nama:<br>
        <input type="text" name="nama"
               value="<?php echo $data['nama']; ?>" required>

        Telpon:<br>
        <input type="text" name="telpon"
               value="<?php echo $data['telpon']; ?>" required>

        Alamat:<br>
        <input type="text" name="alamat"
               value="<?php echo $data['alamat']; ?>" required>

        <button type="submit" name="update">Update</button>
        <a href="index.php">Kembali</a>
    </form>
</div>
</body>
</html>

<?php
mysqli_close($conn);
?>