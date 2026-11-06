<h3>Posted Data: </h3>
<?php
// require 'validate.inc'; 
// if(validateName($_POST, 'surname')){
// 	echo 'Data OK!';
// }else{
// 	echo 'Data invalid!';
// }

require 'form.inc'; 
$errors = array();
validateName($errors, $_POST, 'surname'); 
if ($errors) {
	echo 'Errors:<br/>';
	foreach ($errors as $field => $error)
	echo "$field $error</br>";
} else
	echo 'Data OK!';


echo "<br>";
foreach ($_POST as $key => $value) {

	echo "($key) => ($value) <br>";
}

?>
