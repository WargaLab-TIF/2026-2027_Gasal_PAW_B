<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'invalid';
}

/*
Versi langkah 1 (hanya mengembalikan true / false):

function validateName($field_list, $field_name)
{
    if (!isset($field_list[$field_name]))
        return false;

    $pattern = "/^[a-zA-Z'-]+$/";
    if (!preg_match($pattern, $field_list[$field_name]))
        return false;
    return true;
}
*/
?>
