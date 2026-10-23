<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<h2>Register</h2>
	<fieldset>
		<legend>Person Detail</legend>
		<form name="myForm" action="processData_Form.php" method="POST">
			<div class="field">
				<label for="surname">surname</label>
				<input type="text" name="surname" size="31">
			</div>	
			<div class="field">
				<label for="email">Email address</label>
				<input type="text" name="email" size="31">
			</div>
			<div class="field">
				<label for="passwd">Password</label>
				<input type="Password" name="passwd" size="31">
			</div>
			<div class="field">
				<label for="address">Street Address</label>
				<textarea name="address" rows="3" cols="22"></textarea>
			</div>
			<div class="field">
				<label for="state">State</label>
				<select name="state">
					<option value="-1" selected>[choose your state]</option>
					<option value="1">Australian Capital Territory</option>
					<option value="2">Queensland</option>
					<option value="3">Victoria</option>
					<option value="4">New South Wales</option>
					<option value="5">Tasmania</option>
					<option value="6">South Australia</option>
					<option value="7">Western Australia</option>
					<option value="8">Nothern Australia</option>
				</select>
			</div>
			<div class="field">
				<input type="hidden" name="country" value="Australia">
			</div>
			<div class="field">
				<label for="sex">Gender</label>
				<input type="radio" name="sex" value="male"/>Male
				<input type="radio" name="sex" value="female"/>Female
			</div>
			<div class="field">
				<label for="vegetarian">Vegetarian?</label>
				<input type="checkbox" name="vegetarian" />
			</div>
			<div class="field">
				<label>&nbsp;</label>
				<input type="submit" value="Submit" name="submit" /><input type="reset" value="Reset" name="reset" />
			</div>
		</form>

</fieldset>

</body>
</html>
<?php
foreach ($_POST as $key => $value) {

	echo "($key) => ($value) <br>";
}
?>

