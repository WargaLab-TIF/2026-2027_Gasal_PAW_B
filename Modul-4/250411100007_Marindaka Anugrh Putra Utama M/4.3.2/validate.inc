<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/"; // format surname (alfabet)
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'Surname wajib diisi';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'Surname hanya boleh huruf, apostrof, dan tanda minus';
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'Email wajib diisi';
    else if (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL))
        $errors[$field_name] = 'Format email tidak valid';
}

function validatePassword(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'Password wajib diisi';
    else if (strlen($field_list[$field_name]) < 6)
        $errors[$field_name] = 'Password minimal 6 karakter';
}

function validateAddress(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'Street address wajib diisi';
}

function validateState(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || $field_list[$field_name] == '-1')
        $errors[$field_name] = 'State wajib dipilih';
}
?>
