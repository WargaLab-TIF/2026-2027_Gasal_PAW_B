<?php
require 'validate.inc';

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    validateName($errors, $_POST, 'surname');
    if ($errors)
    {
        echo 'Errors:<br/>';

        foreach ($errors as $field => $error)
            echo "$field $error</br>";
    }
    else
    {
        echo 'Data OK!';
    }
}
 ?>
