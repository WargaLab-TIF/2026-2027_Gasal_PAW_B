<?php
$surname = isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
$state = isset($_POST['state']) ? $_POST['state'] : '-1';
$sex = isset($_POST['sex']) ? $_POST['sex'] : '';
$states = array('Australian Capital Territory', 'Queensland', 'Victoria', 'New South Wales', 'Tasmania', 'South Australia', 'Western Australia', 'Nothern Territory');
?>
<form name="myForm" action="processData_form.php" method="POST">
<fieldset>
<legend>Person Details</legend>
<div>
<label for="surname">Surname</label>
<input type="text" name="surname" size="31" value="<?php echo $surname; ?>"/>
</div>
<div>
<label for="email">Email address</label>
<input type="text" name="email" size="31" value="<?php echo $email; ?>"/>
</div>
<div>
<label for="passwd">Password</label>
<input type="password" name="passwd" size="31"/>
</div>
<div>
<label for="address">Street Address</label>
<textarea name="address" rows="3" cols="22"><?php echo $address; ?></textarea>
</div>
<div>
<label for="state">State</label>
<select name="state">
<option value="-1">[choose your state]</option>
<?php
foreach ($states as $i => $name)
{
    $value = $i + 1;
    $selected = ($state == $value) ? 'selected' : '';
    echo "<option value=\"$value\" $selected>$name</option>";
}
?>
</select>
</div>
<div>
<input type="hidden" name="country" value="Australia">
</div>
<div>
<label for="sex">Gender</label>
<input type="radio" name="sex" value="male" <?php if ($sex == 'male') echo 'checked'; ?>/>Male
<input type="radio" name="sex" value="female" <?php if ($sex == 'female') echo 'checked'; ?>/>Female
</div>
<div>
<label for="vegetarian">Vegetarian?</label>
<input type="checkbox" name="vegetarian" <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?>/>
</div>
<div>
<input type="submit" value="Submit" name="submit" /><input type="reset" value="Reset" name="reset" />
</div>
</fieldset>
</form>
