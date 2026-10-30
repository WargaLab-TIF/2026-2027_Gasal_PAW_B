<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<fieldset>
		<legend>Person Detail</legend>
		<form name="myForm" action="" method="POST">
			<?php
			$errors = array();
			if (isset($_POST['surname'])) {
				require 'validate.inc';
				foreach ($_POST as $keypost => $valuepost) {
					validateName($errors, $_POST, $keypost);
				}
				if ($errors){
					echo '<h1>Invalid, correct the following errors:</h1>';
					foreach ($errors as $field => $error){
						echo "$field $error</br>";
					}
					echo "<br>";
					foreach ($_POST as $key => $value) {
						echo "($key) => ($value) <br>";
					}
					echo "<br>";
					// tampilkan kembali form
					include 'form.inc';
				} else {
					echo 'Form submitted successfully with no errors <br><br>';
				}
					
			} else {
				// tampilkan kembali form
				include 'form.inc';
			}
			?>
		</form>	
	</fieldset>
	
</body>
</html>