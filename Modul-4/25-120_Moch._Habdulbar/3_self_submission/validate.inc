<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'required';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'invalid (letters, - and \' only)';
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'required';
    else if (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL))
        $errors[$field_name] = 'invalid email format';
}

function validatePassword(&$errors, $field_list, $field_name, $min = 6)
{
    if (!isset($field_list[$field_name]) || $field_list[$field_name] === '')
        $errors[$field_name] = 'required';
    else if (strlen($field_list[$field_name]) < $min)
        $errors[$field_name] = "must be at least $min characters";
}

function validateRequired(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'required';
}

function validateState(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || $field_list[$field_name] === '-1')
        $errors[$field_name] = 'please choose a state';
    else if (!preg_match('/^[1-8]$/', $field_list[$field_name]))
        $errors[$field_name] = 'invalid';
}

function validateGender(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!in_array($field_list[$field_name], array('male', 'female'), true))
        $errors[$field_name] = 'invalid';
}
