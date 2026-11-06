<!DOCTYPE html>
<html>
	<head>
		<title>Form Registration soal 1</title>
		<style>
			fieldset {
				background-color: #f8bbd0;
				padding: 5px 10px;
				font-weight: bold;
				border-radius: 4px;
			}
			.field {
				display: flex;
				align-items: center;
				margin-bottom: 7px;
			}
			.field label {
				width: 120px;
			}
		</style>
	</head>
	<body>
		<h2>Register</h2>
		<fieldset>
			<legend><h2>Personal Details</h2></legend>

<?php
require 'validate.inc';

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    validateName($errors, $_POST, 'surname');
    
    if ($errors) {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error) {
            echo "$field $error<br/>";
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