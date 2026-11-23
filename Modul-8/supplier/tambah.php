
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['level'] != 1) {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    $query = mysqli_prepare($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($query, "sss", $nama, $telp, $alamat);

    if (mysqli_stmt_execute($query)) {
        header("Location: data.php");
        exit;
    } else {
        $pesan = "Data supplier gagal ditambahkan.";
    }
}

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Supplier</h4>
        </div>

        <div class="card-body">

            <?php if (isset($pesan)) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($pesan); ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama Supplier</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="telp" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan
                </button>

                <a href="data.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>
        </div>
    </div>
</div>

</body>
</html>
