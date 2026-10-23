<?php
require 'validate.inc';

$errors = array();
$submitted = isset($_POST['submit']);

if ($submitted) {
    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePasswd($errors, $_POST, 'passwd');
    validateRequired($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateRequired($errors, $_POST, 'sex');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <style>
    .field { margin-bottom: 8px; }
    .field label { display: inline-block; width: 120px; vertical-align: top; }
    .error { color: red; margin-left: 8px; }
  </style>
</head>
<body>
<h2>Register</h2>

<?php
if ($submitted) {
    if ($errors) {
        echo '<h3>Invalid, correct the following errors:</h3>';
        foreach ($errors as $field => $error)
            echo "$field $error<br/>";
    } else {
        echo '<h3>Form submitted successfully with no errors</h3>';
        echo '<h3>Posted data:</h3>';
        foreach ($_POST as $key => $value)
            echo "($key) => ($value)<br/>";
    }
}

if (!$submitted || $errors)
    include 'form.inc';
?>
</body>
</html>