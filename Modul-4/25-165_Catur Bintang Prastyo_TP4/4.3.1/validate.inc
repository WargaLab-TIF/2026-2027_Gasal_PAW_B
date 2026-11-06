<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'invalid';
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL))
        $errors[$field_name] = 'invalid';
}

function validatePasswd(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (strlen($field_list[$field_name]) < 6)
        $errors[$field_name] = 'minimal 6 karakter';
}

function validateRequired(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'required';
}

function validateState(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || $field_list[$field_name] == '-1')
        $errors[$field_name] = 'required';
}

function old($field)
{
    return htmlspecialchars($_POST[$field] ?? '');
}

function selected_if($field, $value, $default = false)
{
    if (!isset($_POST[$field]))
        return $default ? 'selected' : '';
    return $_POST[$field] === $value ? 'selected' : '';
}

function checked_if($field, $value)
{
    return (isset($_POST[$field]) && $_POST[$field] === $value) ? 'checked' : '';
}

function showError($errors, $field)
{
    if (isset($errors[$field]))
        return '<span class="error">' . htmlspecialchars($errors[$field]) . '</span>';
    return '';
}