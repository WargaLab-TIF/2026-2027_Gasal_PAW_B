<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="utf-8">

<title>Register</title>

<style>

  body { font-family: Verdana, sans-serif; font-size: 13px; }
  fieldset { background: #dcdcff; width: 480px; border: 1px solid #99c; }
  .field { margin: 4px 0; }
  .field label { display: inline-block; width: 120px; text-align: right; margin-right: 8px; vertical-align: top; }
  .err { color: #c00; font-size: 11px; }

</style>

</head>

<body>

<?php

/*
PENGAMATAN 4.3.2 langkah 6 (self-submission)
- Pertama dibuka, $_POST['surname'] belum ada, sehingga form kosong ditampilkan.
- Submit dengan data benar: tampil "Form submitted successfully with no errors".
- Submit dengan data salah: tampil daftar error, lalu form kosong ditampilkan lagi
  lewat include 'form.inc'.
- Perbedaan dengan 4.3.1 langkah 6: form, validasi, dan pesan error ada dalam satu
  file (form.php) sehingga form langsung muncul lagi untuk diperbaiki tanpa
  berpindah halaman atau menekan Back. Kekurangannya, isian lama hilang.
*/

$errors = array();

if (isset($_POST['surname']))
{
    require 'validate.inc';

    validateName($errors,     $_POST, 'surname');
    validateEmail($errors,    $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateRequired($errors, $_POST, 'address');
    validateState($errors,    $_POST, 'state');
    validateGender($errors,   $_POST, 'sex');

    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error)
            echo "$field $error<br/>";

        include 'form.inc';
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
{
    include 'form.inc';
}
?>

</body>

</html>