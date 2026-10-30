
<!DOCTYPE html>
<html>
<head>
    <title>Validasi Form</title>
</head>
<body>

<?php
$errors = array();

if (isset($_POST['surname']))
{
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');

    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';

        foreach ($errors as $field => $error)
        {
            echo htmlspecialchars($field) . ' '
               . htmlspecialchars($error) . '<br>';
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
