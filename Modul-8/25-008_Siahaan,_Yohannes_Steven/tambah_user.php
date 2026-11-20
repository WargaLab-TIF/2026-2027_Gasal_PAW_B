<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$error = [];
$is_edit = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username_val = htmlspecialchars($_POST["username"] ?? "");
    $password_val = $_POST["password"] ?? "";
    $nama = htmlspecialchars($_POST["nama"] ?? "");
    $alamat = htmlspecialchars($_POST["alamat"] ?? "");
    $hp = htmlspecialchars($_POST["hp"] ?? "");
    $level = $_POST["level"] ?? "";

    validateUsername($error, $username_val);
    validatePasswordUser($error, $password_val, true);
    validateNama($error, $nama);
    validateAlamat($error, $alamat);
    validateHp($error, $hp);
    validateLevel($error, $level);

    if (empty($error) && cekUsernameAda($username_val)) {
        $error["username"] = "Username sudah digunakan";
    }

    if (empty($error)) {
        tambah_user($username_val, $password_val, $nama, $alamat, $hp, $level);
        header("Location: user.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Tambah Data User</h2>
    <form action="" method="post">
        <?php include "components/form_user.php"; ?>
    </form>
</body>
</html>
