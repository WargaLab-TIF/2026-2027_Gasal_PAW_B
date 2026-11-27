<?php
$tabel = 'user';
$pk = 'id_user';
$judul = 'Data User';
$unik = 'username';
$kolom = [
    'name'     => ['label' => 'Nama'],
    'username' => ['label' => 'Username'],
    'password' => ['label' => 'Password', 'type' => 'password'],
    'level'    => ['label' => 'Level', 'type' => 'select', 'opsi' => [1 => 'Owner', 2 => 'Kasir']],
];
include "components/crud.php";
