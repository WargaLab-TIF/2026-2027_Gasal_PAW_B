<?php
$tabel = 'pelanggan';
$pk = 'id_pelanggan';
$judul = 'Data Pelanggan';
$kolom = [
    'nama'   => ['label' => 'Nama'],
    'telp'   => ['label' => 'Telepon'],
    'alamat' => ['label' => 'Alamat'],
];
include "components/crud.php";
