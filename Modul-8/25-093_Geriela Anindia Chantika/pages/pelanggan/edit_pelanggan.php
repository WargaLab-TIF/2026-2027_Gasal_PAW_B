
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../home/index.php");
    exit;
}

require_once "../../config/koneksi.php";

$error = "";

if (!isset($_GET['id'])) {
    header("Location: pelanggan.php");
    exit;
}

$id_awal = $_GET['id'];

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM pelanggan WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "s", $id_awal);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$pelanggan = mysqli_fetch_assoc($hasil);

if (!$pelanggan) {
    header("Location: pelanggan.php");
    exit;
}

if (isset($_POST['update'])) {
    $id = strtoupper(trim($_POST['id']));
    $nama = trim($_POST['nama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if ($id == "" || $nama == "" || $jenis_kelamin == "") {
        $error = "ID, nama, dan jenis kelamin wajib diisi.";
    } elseif (!in_array($jenis_kelamin, ['L', 'P'])) {
        $error = "Jenis kelamin tidak valid.";
    } elseif (strlen($id) > 20 || strlen($nama) > 100 ||
              strlen($telp) > 12) {
        $error = "Panjang data melebihi batas.";
    } elseif ($telp != "" && !preg_match('/^[0-9]+$/', $telp)) {
        $error = "Nomor telepon harus berupa angka.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT id FROM pelanggan
             WHERE id = ? AND id != ?"
        );

        mysqli_stmt_bind_param($stmt, "ss", $id, $id_awal);
        mysqli_stmt_execute($stmt);

        $cek = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cek) > 0) {
            $error = "ID pelanggan sudah digunakan.";
        } else {
            $stmt = mysqli_prepare(
                $koneksi,
                "UPDATE pelanggan
                 SET id = ?,
                     nama = ?,
                     jenis_kelamin = ?,
                     telp = ?,
                     alamat = ?
                 WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssssss",
                $id,
                $nama,
                $jenis_kelamin,
                $telp,
                $alamat,
                $id_awal
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: pelanggan.php?pesan=edit");
                exit;
            } else {
                $error = "Data pelanggan gagal diperbarui.";
            }
        }
    }

    $pelanggan['id'] = $id;
    $pelanggan['nama'] = $nama;
    $pelanggan['jenis_kelamin'] = $jenis_kelamin;
    $pelanggan['telp'] = $telp;
    $pelanggan['alamat'] = $alamat;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <div>
        <span>Data Master</span>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="../supplier/supplier.php">Data Supplier</a>
            <a href="pelanggan.php">Data Pelanggan</a>
            <a href="../user/user.php">Data User</a>
        </div>
    </div>

    <a href="../transaksi/transaksi.php">Transaksi</a>
    <a href="../laporan/laporan.php">Laporan</a>

    <div class="user-dropdown">
    <button class="user-button" type="button">
        <?= htmlspecialchars($_SESSION['nama']); ?>
        <span>▼</span>
    </button>

    <div class="user-dropdown-content">
        <a href="../../auth/logout.php">Logout</a>
    </div>
    </div>
</nav>

<div class="container">

    <h2>Edit Data Pelanggan</h2>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <form method="POST">

        <label>ID Pelanggan</label>
        <input type="text" name="id"
               value="<?= htmlspecialchars($pelanggan['id']); ?>"
               maxlength="20" required>

        <label>Nama Pelanggan</label>
        <input type="text" name="nama"
               value="<?= htmlspecialchars($pelanggan['nama']); ?>"
               maxlength="100" required>

        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="L"
                <?= $pelanggan['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>
                Laki-laki
            </option>
            <option value="P"
                <?= $pelanggan['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>
                Perempuan
            </option>
        </select>

        <label>Nomor Telepon</label>
        <input type="text" name="telp"
               value="<?= htmlspecialchars($pelanggan['telp'] ?? ''); ?>"
               maxlength="12">

        <label>Alamat</label>
        <textarea name="alamat"><?= htmlspecialchars($pelanggan['alamat'] ?? ''); ?></textarea>

        <button type="submit" name="update">Update</button>
        <a href="pelanggan.php" class="btn-kembali">Kembali</a>

    </form>

</div>

</body>
</html>
