<!DOCTYPE html>

<html lang="id">

<head>

  <meta charset="utf-8"><title>Validasi Server-side</title>

</head>

<body>

<?php
require 'validate.inc';

$errors = array();
validateName($errors, $_POST, 'surname');

if ($errors)
{
    echo 'Errors:<br/>';
    foreach ($errors as $field => $error)
        echo "$field $error<br/>";
}
else
    echo 'Data OK!';

/*
PENGAMATAN langkah 3 (validateName versi true/false:
if (validateName($_POST, 'surname')) echo 'Data OK!'; else echo 'Data invalid!';)
- Surname benar (mis. Smith, O'Brien) cocok dengan pola /^[a-zA-Z'-]+$/,
  fungsi mengembalikan true, tampil "Data OK!".
- Surname salah (mis. Smith123, J. Smith, kosong) tidak cocok, fungsi
  mengembalikan false, tampil "Data invalid!".
- Hasilnya hanya valid/tidak valid, tanpa alasan kesalahan.

PENGAMATAN langkah 6 (versi array error, kode di atas)
- Surname benar: tampil "Data OK!".
- Surname kosong: tampil "surname required".
- Surname berisi angka/simbol: tampil "surname invalid".
- Perbedaan dengan langkah 3: pesan error kini spesifik (field mana dan jenis
  kesalahannya) karena disimpan di array $errors yang dikirim by reference (&$errors),
  sehingga bisa menampung error banyak field sekaligus.
*/

?>
</body>

</html>
