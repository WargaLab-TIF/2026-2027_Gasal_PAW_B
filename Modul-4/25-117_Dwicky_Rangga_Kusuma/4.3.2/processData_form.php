<?php
$errors = array();

if (isset($_POST['surname']))
{
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'password');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateGender($errors, $_POST, 'gender');

    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';

        foreach ($errors as $field => $error)
            echo "$field $error</br>";

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

// Pengamatan langkah 6:
// Pada self-submission, form dikirim ke file PHP yang sama. Jika validasi gagal, pesan error ditampilkan dan form ditampilkan kembali.

// Pengamatan langkah 8:
// Setelah form.inc diubah, data yang sebelumnya diisi tetap muncul. ketika validasi gagal. Pada langkah 6, form ditampilkan kembali tanpa mempertahankan seluruh isian sebelumnya.
 ?>