
<!DOCTYPE html>
<html>
<head>
    <title>Validasi Form</title>
</head>
<body>

<?php
if (isset($_SERVER['REQUEST_METHOD']) &&
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['surname']))
{
    require 'validate.inc';

    $errors = array();

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validateState($errors, $_POST, 'state');

    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';

        foreach ($errors as $field => $error) {
            echo htmlspecialchars($field, ENT_QUOTES, 'UTF-8') . ' '
               . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '<br>';
        }

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
