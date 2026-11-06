<!DOCTYPE html>
<html>
<head>
    <title>Form Input Handling - Self Submission</title>
    <style>
        .success { background: #e8f5e9; color: #2e7d32; padding: 20px; border-radius: 8px; max-width: 500px; margin: 40px auto; font-family: Arial, sans-serif; }
        .error-header { color: #c62828; font-family: Arial, sans-serif; margin: 20px 40px 10px; }
    </style>
</head>
<body>
<?php
$errors = array();

if (isset($_POST['surname'])) {
    // Form sudah di-submit → lakukan validasi
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateGender($errors, $_POST, 'sex');

    if ($errors) {
        // Ada error → tampilkan pesan error + form lagi (dengan data yang sudah diisi)
        echo '<h1 class="error-header">Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error) {
            echo "<p style='color:#c62828; margin-left:40px; font-family:Arial;'>$field → $error</p>";
        }
        // Tampilkan kembali form
        include 'form.inc';
    } else {
        // Tidak ada error → sukses
        echo '<div class="success">';
        echo '<h2>Form submitted successfully with no errors!</h2>';
        echo '<p><strong>Data yang dikirim:</strong></p>';
        echo '<ul>';
        foreach ($_POST as $key => $value) {
            if ($key != 'submit' && $key != 'reset') {
                echo '<li><strong>' . htmlspecialchars($key) . '</strong>: ' . htmlspecialchars($value) . '</li>';
            }
        }
        echo '</ul>';
        echo '</div>';
    }
} else {
    // Belum ada data → tampilkan form kosong
    include 'form.inc';
}
?>
</body>
</html>
