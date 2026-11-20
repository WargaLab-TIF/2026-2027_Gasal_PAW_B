<?php
include 'auth.php';
wajibLogin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda Sistem Penjualan</title>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <h2>Selamat Datang di Sistem Penjualan</h2>

    <p>
        Halo,
        <?php echo htmlspecialchars($_SESSION['nama']); ?>
    </p>

    <?php if ($_SESSION['level'] == 1) { ?>

        <p>Login sebagai Owner</p>

    <?php } else { ?>

        <p>Login sebagai Kasir</p>

    <?php } ?>

</body>
</html>