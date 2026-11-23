<?php
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/";

    if (!isset($field_list[$field_name]) ||
        empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'invalid';
}

function validateEmail(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL))
        $errors[$field_name] = 'invalid';
}

function validatePassword(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
}

function validateAddress(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        empty(trim($field_list[$field_name])))
        $errors[$field_name] = 'required';
}

function validateState(&$errors, $field_list, $field_name)
{
    $states = array(
        'Australian Capital Territory',
        'Queensland',
        'New South Wales',
        'Victoria',
        'South Australia',
        'Western Australia',
        'Tasmania',
        'Northern Territory'
    );

    if (!isset($field_list[$field_name]) ||
        empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!in_array($field_list[$field_name], $states))
        $errors[$field_name] = 'invalid';
}

function validateGender(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) ||
        !in_array($field_list[$field_name], array('Male', 'Female')))
        $errors[$field_name] = 'required';
}
 ?>