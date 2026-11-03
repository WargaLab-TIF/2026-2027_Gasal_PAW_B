<?php
// $errors = array();

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $pattern = "/^[a-zA-Z'-]+$/";

//     if (trim($_POST['surname'] ?? '') == '') {
//         $errors['surname'] = 'required';
//     } elseif (!preg_match($pattern, trim($_POST['surname']))) {
//         $errors['surname'] = 'invalid';
//     }

//     if (!empty($errors)) {
//         echo '<h1>Invalid, correct the following errors:</h1>';

//         foreach ($errors as $field => $error) {
//             echo htmlspecialchars($field) . ' '
//                 . htmlspecialchars($error) . '<br>';
//         }
//     include 'form.inc';

//     } else {
//         echo '<h1>Form submitted successfully with no errors</h1>';
//     }
// }

$errors = array();

if (isset($_POST['submit'])) {
    $surname = trim($_POST['surname'] ?? '');

    if ($surname == '') {
        $errors['surname'] = 'required';
    } elseif (!preg_match("/^[a-zA-Z'-]+$/", $surname)) {
        $errors['surname'] = 'invalid';
    }

    if ($errors) {
        echo '<h1>Invalid, correct the following errors:</h1>';

        foreach ($errors as $field => $error) {
            echo htmlspecialchars($field) . ' '
                . htmlspecialchars($error) . '<br>';
        }
    } else {
        echo '<h1>Form submitted successfully with no errors</h1>';
    }
}

include 'form.inc';
?>
