<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$error = [];
$mode = "tambah";
$id = 0;
$username = $nama = $alamat = $hp = $level = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $nama = trim($_POST["nama"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");
    $hp = trim($_POST["hp"] ?? "");
    $level = $_POST["level"] ?? "";

    validasiUser($error, $mode, 0, $username, $password, $nama, $hp, $level);

    if (empty($error)) {
        tambahUser($username, $password, $nama, $alamat, $hp, $level);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah User</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Tambah User</h2>
    <form action="" method="post">
        <?php include "../components/form_user.php"; ?>
    </form>
</body>
</html>
