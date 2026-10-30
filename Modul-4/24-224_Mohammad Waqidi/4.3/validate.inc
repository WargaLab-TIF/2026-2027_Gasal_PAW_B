
<?php

function validateName(&$errors, $field_list, $field_name)
{
    $value = trim($field_list[$field_name] ?? '');
    $pattern = "/^[a-zA-Z'-]+$/";

    if ($value === '') {
        $errors[$field_name] = 'required';
    } elseif (!preg_match($pattern, $value)) {
        $errors[$field_name] = 'invalid';
    }
}

function validateEmail(&$errors, $field_list, $field_name)
{
    $value = trim($field_list[$field_name] ?? '');

    if ($value === '') {
        $errors[$field_name] = 'required';
    } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $errors[$field_name] = 'invalid';
    }
}

function validatePassword(&$errors, $field_list, $field_name)
{
    $value = $field_list[$field_name] ?? '';

    if ($value === '') {
        $errors[$field_name] = 'required';
    } elseif (strlen($value) < 8) {
        $errors[$field_name] = 'invalid';
    }
}

function validateAddress(&$errors, $field_list, $field_name)
{
    $value = trim($field_list[$field_name] ?? '');

    if ($value === '') {
        $errors[$field_name] = 'required';
    }
}

function validateState(&$errors, $field_list, $field_name)
{
    $value = $field_list[$field_name] ?? '';
    $allowed = array('1', '2', '3', '4', '5', '6', '7', '8');

    if ($value === '' || $value === '-1') {
        $errors[$field_name] = 'required';
    } elseif (!in_array($value, $allowed, true)) {
        $errors[$field_name] = 'invalid';
    }
}

function validateGender(&$errors, $field_list, $field_name)
{
    $value = $field_list[$field_name] ?? '';

    if ($value === '') {
        $errors[$field_name] = 'required';
    } elseif (!in_array($value, array('Male', 'Female'), true)) {
        $errors[$field_name] = 'invalid';
    }
}

?>
