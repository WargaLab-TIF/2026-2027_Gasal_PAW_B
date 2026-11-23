
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
    if (!isset($field_list[$field_name]) ||
        trim($field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    } elseif (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL)) {
        $errors[$field_name] = 'invalid email format';
    }
}

function validateState(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        !in_array($field_list[$field_name], ['1','2','3','4','5','6','7','8'], true)) {
        $errors[$field_name] = 'please choose a state';
    }
}
?>
