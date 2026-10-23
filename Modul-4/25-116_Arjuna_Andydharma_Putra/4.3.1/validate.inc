<?php
/**
 * Fungsi validasi surname
 * Versi final (langkah 4) - menyimpan pesan error ke array $errors
 */
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/"; // format surname (alfabet + ' dan -)

    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'invalid';
}
?>
