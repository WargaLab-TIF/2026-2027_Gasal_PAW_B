
<?php
$errors = array();
$isSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($isSubmitted) {
    require_once 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'password');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateGender($errors, $_POST, 'sex');
}

$labels = array(
    'surname' => 'Surname',
    'email' => 'Email Address',
    'password' => 'Password',
    'address' => 'Street Address',
    'state' => 'State',
    'sex' => 'Gender'
);

$messages = array(
    'surname' => array(
        'required' => 'wajib diisi.',
        'invalid' => 'hanya boleh berisi huruf, tanda petik, atau tanda hubung.'
    ),
    'email' => array(
        'required' => 'wajib diisi.',
        'invalid' => 'format email tidak valid.'
    ),
    'password' => array(
        'required' => 'wajib diisi.',
        'invalid' => 'minimal 8 karakter.'
    ),
    'address' => array(
        'required' => 'wajib diisi.'
    ),
    'state' => array(
        'required' => 'harus dipilih.',
        'invalid' => 'pilihan State tidak valid.'
    ),
    'sex' => array(
        'required' => 'harus dipilih.',
        'invalid' => 'pilihan Gender tidak valid.'
    )
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<h1>Register</h1>

<?php
if ($isSubmitted && $errors) {
    echo '<h2>Invalid, correct the following errors:</h2>';

    foreach ($errors as $field => $error) {
        echo '<p><strong>'
            . htmlspecialchars($labels[$field], ENT_QUOTES, 'UTF-8')
            . ':</strong> '
            . htmlspecialchars($messages[$field][$error], ENT_QUOTES, 'UTF-8')
            . '</p>';
    }

    include 'form.inc';

} elseif ($isSubmitted) {
    echo 'Form submitted successfully with no errors';

} else {
    include 'form.inc';
}
?>

</body>
</html>
