<?php

function bukaKoneksi()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "db_modul5";

    $koneksi = mysqli_connect($host, $user, $pass, $db);

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    return $koneksi;
}

function queryDatabase($koneksi, $sql)
{
    $hasil = mysqli_query($koneksi, $sql);

    if (!$hasil) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    return $hasil;
}

function updateData($koneksi, $id_ms, $nama, $telp, $alamat)
{
    $sql = "UPDATE master_supplier
            SET Nama = ?, Telp = ?, Alamat = ?
            WHERE id_ms = ?";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $nama,
        $telp,
        $alamat,
        $id_ms
    );

    return mysqli_stmt_execute($stmt);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_ms = $_GET["id"];
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];

    $koneksi = bukaKoneksi();

    if (updateData($koneksi, $id_ms, $nama, $telp, $alamat)) {
        header("Location: data_master_supplier.php");
        exit;
    }
    mysqli_close($koneksi);
}

$koneksi = bukaKoneksi();

if (!isset($_GET['id'])) {
    header("Location: data_master_supplier.php");
    exit;
}
$id_ms = $_GET['id'];

$sqlAmbilData = "SELECT * FROM master_supplier WHERE id_ms = '$id_ms'";
$hasilData = queryDatabase($koneksi, $sqlAmbilData);
$dataLama = mysqli_fetch_assoc($hasilData);

if (!$dataLama) {
    die("Data supplier tidak ditemukan.");
}
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Master Supplier</title>
    
    <!-- ini css -->
    <style>
        .container {
            font-family: sans-serif;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
        }
        .judul {
            margin: 0;
            color: #4682B4;
            font-size: 24px;
            font-weight: 500;
        }
        .garis-bawah {
            border-bottom: 2px solid #f0f0f0;
            margin-top: 10px;
            margin-bottom: 30px;
            width: 100%;
        }
        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        .form-row label {
            width: 100px;
            font-weight: bold;
            text-align: right;
            margin-right: 20px;
            color: #333;
        }
        .form-row input {
            flex: 1;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .tombol-group {
            margin-left: 120px;
            display: flex;
            gap: 10px;
        }
        .btn-update {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-batal {
            background-color: #C0392B;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    
    <!-- Judulnya -->
    <p class="judul">Edit Data Master Supplier</p> 
    <div class="garis-bawah"></div>

    <form method="post">
        
        <!-- Nama ptnya -->
        <div class="form-row">
            <label>Nama</label>
            <input type="text" name="nama" value="<?php echo isset($dataLama['Nama']) ? htmlspecialchars($dataLama['Nama']) : ''; ?>" required>
        </div>

        <!-- Telp -->
        <div class="form-row">
            <label>Telp</label>
            <input type="text" name="telp" value="<?php echo isset($dataLama['Telp']) ? htmlspecialchars($dataLama['Telp']) : ''; ?>" required>
        </div>

        <!-- Alamat -->
        <div class="form-row">
            <label>Alamat</label>
            <input type="text" name="alamat" value="<?php echo isset($dataLama['Alamat']) ? htmlspecialchars($dataLama['Alamat']) : ''; ?>" required>
        </div>

        <!--Tombol Aksi-->
        <div class="tombol-group">
            <button type="submit" name="update" class="btn-update">Update</button>
            <a href="data_master_supplier.php" class="btn-batal">Batal</a>
        </div>

    </form>
</div>

</body>
</html>