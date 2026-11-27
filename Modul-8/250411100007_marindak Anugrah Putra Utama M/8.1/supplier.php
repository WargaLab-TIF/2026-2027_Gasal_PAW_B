<?php
$tabel = 'supplier';
$pk = 'id_supplier';
$judul = 'Data Supplier';
$kolom = [
    'nama'   => ['label' => 'Nama'],
    'telp'   => ['label' => 'Telepon'],
    'alamat' => ['label' => 'Alamat'],
];
include "components/crud.php";
