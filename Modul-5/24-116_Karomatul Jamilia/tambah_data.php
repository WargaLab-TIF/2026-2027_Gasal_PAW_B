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

function tambahData($koneksi, $nama, $telp, $alamat)
{
    $sql = "INSERT INTO master_supplier(Nama, Telp, Alamat)
    VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);

    return mysqli_stmt_execute($stmt);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];

    $koneksi = bukaKoneksi();

    if (tambahData($koneksi, $nama, $telp, $alamat)) {
        header("Location: data_master_supplier.php");
        exit;
    } else {
        echo "Data gagal disimpan.<br>";}

    mysqli_close($koneksi);
}

$koneksi = bukaKoneksi();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Master Supplier Baru</title>
    
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
        .btn-tambah {
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
    <p class="judul">Tambah Data Master Supplier Baru</p> 
    <div class="garis-bawah"></div>

    <form method="post">
        
        <!-- Nama ptnya -->
        <div class="form-row">
            <label>Nama</label>
            <input type="text" name="nama" required>
        </div>

        <!-- Telp -->
        <div class="form-row">
            <label>Telp</label>
            <input type="text" name="telp" required>
        </div>

        <!-- Alamat -->
        <div class="form-row">
            <label>Alamat</label>
            <input type="text" name="alamat" required>
        </div>

        <!--Tombol Aksi-->
        <div class="tombol-group">
            <button type="submit" name="tambah" class="btn-tambah">Tambah</button>
            <a href="data_master_supplier.php" class="btn-batal">Batal</a>
        </div>

    </form>
</div>

</body>
</html>