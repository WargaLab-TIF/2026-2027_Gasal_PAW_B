<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";

    if (!isset($field_list[$field_name]) ||
        empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'invalid';
}

// Hasil Pengujian Validasi Field Lain

// Validasi server-side dapat ditambahkan pada field lain, misalnya email.
// Jika format email tidak sesuai, program menampilkan pesan kesalahan yang
// sesuai dengan field tersebut. Dengan validasi ini, program dapat memeriksa
// lebih dari satu field sebelum menampilkan pesan bahwa form berhasil dikirimkan.
?>