
<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";

    if (!isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    }
    else if (!preg_match($pattern, $field_list[$field_name])) {
        $errors[$field_name] = 'invalid';
    }
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    }
    else if (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL)) {
        $errors[$field_name] = 'invalid';
    }
}



function validatePassword(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    }
    else if (strlen($field_list[$field_name]) < 8) {
        $errors[$field_name] = 'too short (minimum 8 characters)';
    }
}

function validateAddress(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    }
}

function validateState(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        $field_list[$field_name] === '-1') {
        $errors[$field_name] = 'required';
    }
}

function validateGender(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        !in_array($field_list[$field_name], ['male', 'female'], true)) {
        $errors[$field_name] = 'required';
    }
}

?>
