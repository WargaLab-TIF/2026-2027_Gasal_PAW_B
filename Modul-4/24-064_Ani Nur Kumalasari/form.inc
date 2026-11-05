<fieldset>
	<legend>person Details</legend>
<form name="myForm" action="register.php" method="POST">
		<div class="field">
			<label for="surname">Surname</label>
			<input type type="text" name="surname" size="31"/>
		</div><br>
		<div class="field">
			<label for="email">Email address</label>
			<input type="text" name="email" size="31">
		</div><br>
		<div class="field">
			<label for="passwd">password</label>
			<input type="password" name="passwd" size="31"/>
		</div><br>
		<div class="field">
			<label for="address">Street address</label>
			<textarea name="address" rows="3" cols="22"></textarea>
		</div><br>
		<div class="field">
			<label for="state">state</label>
			<select name="state">
				<option value="-1" selected>[choose your state]</option>
				<option value="1"> Australian Capital Territory</option>
				<option value="2"> Queensland</option>
				<option value="3"> Victoria</option>
				<option value="4"> New South</option>
				<option value="5"> Tasmania</option>
				<option value="6"> South Australia</option>
				<option value="7"> Western Australia</option>
				<option value="8"> Nosthern Territory</option>
			</select>
		</div><br>
		<div class="field">
			<input type="hidden" name="country" value="Australia">
		</div><br>
		<div class="field">
			<label for="sex">Gender</label>
			<input type="radio" name="sex" value="male"/>male
			<input type="radio" name="sex" value="female"/>female
		</div><br>
		<div class="field">
			<label for="vegetarian">Vegetarian?</label>
			<input type="checkbox" name="vegetarian"/>
		</div><br>
		<div class="field">
			<label>&nbsp;</label>
			<input type="submit" value="Submit" name="submit"/>
			<input type="reset" value="Reset" name="reset"/>
		</div>
	</form>
</fieldset>