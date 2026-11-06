<?php
$errors = array();
if (isset($_POST['surname']))
{
    require 'validate.inc';
    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');

    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error)
            echo "$field: $error<br/>";

        // tampilkan kembali form (dengan isian data)
        include 'form.inc';
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
    // tampilkan form kosong
    include 'form.inc';
?>
