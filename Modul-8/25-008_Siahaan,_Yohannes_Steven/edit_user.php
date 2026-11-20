<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$error = [];
$is_edit = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_user = $_POST["id_user"] ?? "";
    $username_val = htmlspecialchars($_POST["username"] ?? "");
    $password_val = $_POST["password"] ?? "";
    $nama = htmlspecialchars($_POST["nama"] ?? "");
    $alamat = htmlspecialchars($_POST["alamat"] ?? "");
    $hp = htmlspecialchars($_POST["hp"] ?? "");
    $level = $_POST["level"] ?? "";

    validateUsername($error, $username_val);
    validatePasswordUser($error, $password_val, false);
    validateNama($error, $nama);
    validateAlamat($error, $alamat);
    validateHp($error, $hp);
    validateLevel($error, $level);

    if (empty($error)) {
        update_user($id_user, $username_val, $password_val, $nama, $alamat, $hp, $level);
        header("Location: user.php");
        exit();
    }
} else {
    $id_user = $_GET["id"] ?? 0;
    $data = getUserById($id_user);
    if (!$data) {
        header("Location: user.php");
        exit();
    }
    $username_val = $data["username"];
    $nama = $data["nama"];
    $alamat = $data["alamat"];
    $hp = $data["hp"];
    $level = $data["level"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Edit Data User</h2>
    <form action="" method="post">
        <?php include "components/form_user.php"; ?>
    </form>
</body>
</html>
