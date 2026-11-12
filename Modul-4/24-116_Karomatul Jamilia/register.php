
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h1>Register</h1>

<fieldset>
    <legend>Person Detail</legend>

    <?php
    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require 'validate.inc';

        validateName($errors, $_POST, 'surname');
		validateEmail($errors, $_POST, 'email');
		validatePassword($errors, $_POST, 'passwd');
		validateAddress($errors, $_POST, 'address');
		validateState($errors, $_POST, 'state');
		validateGender($errors, $_POST, 'sex');

        if (!empty($errors)) {
            echo '<h3>Invalid, correct the following errors:</h3>';

            foreach ($errors as $field => $error) {
                echo htmlspecialchars($field) . ' ' .
                     htmlspecialchars($error) . '<br>';
            }

            include 'form.inc';
        } else {
            echo 'Form submitted successfully with no errors';
        }
    } else {
        include 'form.inc';
    }
    ?>

</fieldset>

</body>
</html>
