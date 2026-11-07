<?php

function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/"; // format surname

    if (
        !isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === ''
    ) {
        $errors[$field_name] = 'required';
    } elseif (!preg_match($pattern, $field_list[$field_name])) {
        $errors[$field_name] = 'invalid';
    }
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (
        !isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === ''
    ) {
        $errors[$field_name] = 'required';
    } elseif (
        !filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL)
    ) {
        $errors[$field_name] = 'invalid';
    }
}

function validateRequired(&$errors, $field_list, $field_name)
{
    if (
        !isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === ''
    ) {
        $errors[$field_name] = 'required';
    }
}

?>
