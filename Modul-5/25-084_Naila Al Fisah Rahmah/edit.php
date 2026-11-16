
<?php
require 'koneksi.php';

mysqli_select_db($conn, "Modul 5");

$id = (int) $_GET['id'];

// Mengambil data berdasarkan ID
$query = "SELECT * FROM dataMaster WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Data tidak ditemukan!");
}

// Memeriksa tombol update
if (isset($_POST['update'])) {

    $Nama = mysqli_real_escape_string($conn, $_POST['Nama']);
    $Telp = mysqli_real_escape_string($conn, $_POST['Telp']);
    $Alamat = mysqli_real_escape_string($conn, $_POST['Alamat']);

    $query = "UPDATE dataMaster SET
              Nama = '$Nama',
              Telp = '$Telp',
              Alamat = '$Alamat'
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengubah data: " . mysqli_error($conn);
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

    <form method="POST">

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="Nama"
                value="<?php echo htmlspecialchars($row['Nama']); ?>"
                required>
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="Telp"
                value="<?php echo htmlspecialchars($row['Telp']); ?>"
                required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="Alamat"
                value="<?php echo htmlspecialchars($row['Alamat']); ?>">
        </div>

        <div class="form-group">
            <label></label>
            <button type="submit" name="update" class="btn update">
                Update
            </button>

            <a href="index.php" class="btn batal">Batal</a>
        </div>

    </form>

</body>
</html>
