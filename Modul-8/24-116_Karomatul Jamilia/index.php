<?php
include "midlewire.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>
    <h1>Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?></h1>
    <p>Anda login sebagai <?= $_SESSION['level'] == 1 ? "Owner" : "Kasir" ?>.</p>
</body>
</html>
