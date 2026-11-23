
<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM suplier WHERE id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama = trim($_POST['nama']);
    $tlp = trim($_POST['tlp']);
    $alamat = trim($_POST['alamat']);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE suplier
         SET nama = ?, tlp = ?, alamat = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt, "sssi", $nama, $tlp, $alamat, $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }

    echo "Gagal mengubah data.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Supplier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 30px;
        }
        h2 {
            font-size: 24px;
            font-weight: normal;
            color: #568da5;
            margin: 0 0 18px 0;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        form {
            width: 430px;
            margin-left: 70px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        label {
            width: 70px;
            text-align: right;
            margin-right: 15px;
            font-weight: bold;
            color: #555;
        }
        input {
            width: 250px;
            padding: 6px 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 27px;
            box-sizing: border-box;
            font-size: 12px;
        }
        input:focus {
            outline: none;
            border-color: #66afe9;
            box-shadow: 0 0 5px rgba(102, 175, 233, .5);
        }
        .tombol {
            margin-left: 85px;
            margin-top: 2px;
        }
        button, .btn-batal {
            display: inline-block;
            padding: 7px 11px;
            border: 1px solid transparent;
            border-radius: 4px;
            color: white;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-simpan {
            background: #75ad45;
            border-color: #649b37;
        }
        .btn-update {
            background: #75ad45;
            border-color: #649b37;
        }
        .btn-batal {
            background: #c82333;
            border-color: #bd2130;
        }
        .btn-simpan:hover,
        .btn-update:hover {
            background: #63963a;
        }
        .btn-batal:hover {
            background: #a71d2a;
        }
    </style>
</head>
<body>
<h2>Edit Data Master Supplier</h2>
<form method="POST">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama"
               value="<?= htmlspecialchars($data['nama']); ?>"
               required>
    </div>
    <div class="form-group">
        <label>Telp</label>
        <input type="text" name="tlp"
               value="<?= htmlspecialchars($data['tlp']); ?>"
               maxlength="12" required>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat"
               value="<?= htmlspecialchars($data['alamat'] ?? ''); ?>"
               maxlength="50">
    </div>
    <div class="tombol">
        <button type="submit" name="update" class="btn-update">
            Update
        </button>
        <a href="index.php" class="btn-batal">Batal</a>
    </div>
</form>
</body>
</html>
