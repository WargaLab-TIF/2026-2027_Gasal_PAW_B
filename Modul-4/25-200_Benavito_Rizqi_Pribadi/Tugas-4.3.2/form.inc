<h1>Register</h1>
<fieldset>
	<legend>Person Details </legend>
		<form name="myForm" action="prosesData_form.php" method="POST">
			<div class="field">
				<label for="surname">Surname</label>
				<input type="text" name="surname" size="31">
			</div>
			<div class="field">
				<label for="email">Email address</label>
				<input type="email" name="email" size="31">
			</div>
			<div class="field">
				<label for="password">Password</label>
				<input type="password" name="password" size="31">
			</div>
			<div class="field">
				<label for="address">Street Address</label>
				<textarea type="text" name="address" cols="22"></textarea>
			</div>
			<div class="field">
				<label for="state">State</label>
				<select name="state">
					<option value="-1" selected>[choose your state]</option>
					<option value="1">Asustralian Capital Territory</option>
					<option value="2">Queenland</option>
					<option value="3">Victoria</option>
					<option value="4">New South Males</option>
					<option value="5">Tasmania</option>
					<option value="6">South Australia</option>
					<option value="7">Sestern Australia</option>
					<option value="8">Nothern Australia</option>
				</select>
			</div>
		<div class="field">
			<input type="hidden" name="country" value="Australia">
		</div>
		<div class="field">
			<label for="sex">Gender</label>
			<input type="radio" name="sex" value="male"> Male	
			<input type="radio" name="sex" value="female"> Female
		</div>
		<div class="field">
			<label for="vegetarian">Vegetarian</label>
			<input type="checkbox" name="vegetarian">
		</div>
		<div class="field">
			<label>&nbsp</label>
			<input type="submit" value="Submit" name="submit"/><input type="reset" value="Reset" name="reset">
		</div>
		</form>
</fieldset>

<?php
echo "<br>";
foreach ($_POST as $key => $value) {
	echo "($key) => ($value) <br>";
}
?>