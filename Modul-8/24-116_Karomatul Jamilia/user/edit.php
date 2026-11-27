<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$error = [];
$mode = "edit";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $nama = trim($_POST["nama"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");
    $hp = trim($_POST["hp"] ?? "");
    $level = $_POST["level"] ?? "";

    validasiUser($error, $mode, $id, $username, $password, $nama, $hp, $level);


    if (empty($error)) {
        updateUser($id, $username, $password, $nama, $alamat, $hp, $level);

        header("Location: index.php");
        exit();
    }
} else {
    $id = $_GET["id"] ?? 0;
    $data = getUserById($id);

    if (!$data) {
        header("Location: index.php");
        exit();
    }

    $username = $data["username"];
    $nama = $data["nama"];
    $alamat = $data["alamat"];
    $hp = $data["hp"];
    $level = (string)$data["level"];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit User</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Edit User</h2>
    <form action="" method="post">
        <?php include "../components/form_user.php"; ?>
    </form>
</body>
</html>
