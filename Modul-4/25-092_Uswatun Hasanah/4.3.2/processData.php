<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Register</title>
  <style>
    body { font-family: Verdana, sans-serif; font-size: 12px; }
    fieldset { background: #dde; width: 420px; }
    .field { margin: 3px 0; }
    .field label { display: inline-block; width: 110px; text-align: right; margin-right: 6px; vertical-align: top; }
    .error { color: #c00; }
  </style>
</head>
<body>
<h1>Register</h1>
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
    validateGender($errors, $_POST, 'sex');

    if ($errors)
    {
        echo '<h2 class="error">Invalid, correct the following errors:</h2>';
        echo '<div class="error">';
        foreach ($errors as $field => $error)
            echo "$field $error</br>";
        echo '</div><br/>';

       
        include 'form.inc';
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
{
    include 'form.inc';
}
?>
</body>
</html>
