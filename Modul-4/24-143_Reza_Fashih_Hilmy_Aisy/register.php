
<?php
$errors = array();
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;

    require_once 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validateRequired($errors, $_POST, 'passwd');
    validateRequired($errors, $_POST, 'address');

    if (!isset($_POST['state']) || $_POST['state'] === '-1') {
        $errors['state'] = 'required';
    }

    if (!isset($_POST['sex'])) {
        $errors['sex'] = 'required';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>
<body>

<?php if ($submitted && empty($errors)) { ?>

    <h1>Form submitted successfully with no errors</h1>

<?php } else { ?>

    <h1>Register</h1>

    <?php if (!empty($errors)) { ?>
        <h2>Invalid, correct the following errors:</h2>

        <?php foreach ($errors as $field => $error) { ?>
            <p>
                <?= htmlspecialchars($field) ?>:
                <?= htmlspecialchars($error) ?>
            </p>
        <?php } ?>
    <?php } ?>

    <form name="myForm" action="register.php" method="POST">
        <?php include 'form.inc'; ?>
    </form>

<?php } ?>

</body>
</html>
