<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM users");

while ($data = mysqli_fetch_assoc($query)) {

    $password = $data['password'];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($koneksi, "
        UPDATE users 
        SET password = '$hash'
        WHERE id_user = '{$data['id_user']}'
    ");
}

echo "Password berhasil di-hash!";
?>