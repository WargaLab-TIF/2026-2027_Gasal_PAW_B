<?php
require 'validate.inc';

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    validateName($errors, $_POST, 'surname');
    if ($errors)
    {
        echo 'Errors:<br/>';

        foreach ($errors as $field => $error)
            echo "$field $error</br>";
    }
    else
    {
        echo 'Data OK!';
    }
}
// Pengamatan langkah 3:
// Surname dengan format alfabet menghasilkan Data OK!. Surname yang mengandung angka atau simbol di luar pola menghasilkan Data invalid!. Pada versi awal, hasil validasi hanya berupa status valid atau tidak valid.

// Pengamatan langkah 6:
// Setelah validasi diubah menggunakan array $errors, sistem dapat menampilkan nama field dan jenis kesalahan, seperti surname required atau surname invalid.
 ?>