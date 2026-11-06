<form name="myForm" action="form.php" method="POST">
	<div class="field">
		<label for="surename">Surename</label>
		<input type="text" name="surename" size="31" value="<?php echo htmlspecialchars($_POST['surname'] ?? ''); ?>">
	</div>
	<div class="field">
		<label for="email">email</label>
		<input type="text" name="email" size="31"/>
	</div>
	<div class="field">
		<label for="passwd">Password</label>
		<input type="password" name="passwd" size="31"/>
	</div>
	<div class="field">
		<label for="address">Street Address</label>
		<textarea name="address" row="3" cols="30"></textarea>
	</div>
	<div class="field">
		<label for="state">State</label>
		<select name="state"> 
			<option value="-1" selected>[chose your state]</option>
			<option value="1">Australian Capital Territory</option>
			<option value="2">Queensland</option>
			<option value="3">Victoria</option>
			<option value="4">New South Wales</option>
			<option value="5">Tasmania</option>
			<option value="6">South Australia</option>
			<option value="7">Wastern Australia</option>
			<option value="8">Nothern Territory</option>
		</select>
	</div>
	<div class="field">
		<input type="hidden" name="country" value="Australia"/>
	</div>
	<div class="field">
		<label for="sex">Gender</label>
		<input type="radio" name="sex" value="male"/>Male
		<input type="radio" name="sex" value="famale"/>Famale
	</div>
	<div class="field">
		<label for="vegetarian">Vegetarian?</label>
		<input type="checkbox" name="vegetarian"/>
	</div>
	<div class="field">
		<label for="&nbsp;"></label>
		<input type="submit" name="submit" value="submit"/>
		<input type="reset" name="reset" value="reset"/>
	</div>		
</form>