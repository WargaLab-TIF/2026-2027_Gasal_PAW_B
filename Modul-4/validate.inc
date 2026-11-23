<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";

    if (!isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    } elseif (!preg_match($pattern, $field_list[$field_name])) {
        $errors[$field_name] = 'invalid';
    }
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (empty(trim($field_list[$field_name] ?? ''))) {
        $errors[$field_name] = 'required';
    } elseif (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL)) {
        $errors[$field_name] = 'invalid email';
    }
}

function validateGender(&$errors, $field_list, $field_name)
{
    if (!in_array($field_list[$field_name] ?? '', ['Male', 'Female'], true)) {
        $errors[$field_name] = 'required or invalid';
    }
}
?>
