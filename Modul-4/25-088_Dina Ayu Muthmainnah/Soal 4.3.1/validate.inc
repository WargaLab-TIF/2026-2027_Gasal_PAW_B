<?php
// function validateName($data, $field) {
//     if (isset($data[$field]) && preg_match("/^[a-zA-Z ]+$/", $data[$field])) {
//         return true;
//     }
//     return false;
// }

function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";

    if (!isset($field_list[$field_name]) ||
        empty($field_list[$field_name])) {
        $errors[$field_name] = 'required';
    }
    elseif (!preg_match($pattern, $field_list[$field_name])) {
        $errors[$field_name] = 'invalid';
    }
}
?>