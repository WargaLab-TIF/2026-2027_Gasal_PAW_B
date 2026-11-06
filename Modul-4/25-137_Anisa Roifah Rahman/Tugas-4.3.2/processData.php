<?php
$errors = array();

if (isset($_POST['surname']))
{
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validateRequired($errors, $_POST, 'address');

    if (!isset($_POST['state']) || $_POST['state'] == '-1')
        $errors['state'] = 'required';

    if (!isset($_POST['sex']))
        $errors['sex'] = 'required';

    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';

        foreach ($errors as $field => $error)
            echo "$field $error<br/>";

        include 'form.inc';
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
    include 'form.inc';
?>