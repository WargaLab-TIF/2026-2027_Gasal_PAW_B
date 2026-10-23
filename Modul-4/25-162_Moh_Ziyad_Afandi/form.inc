<?php
$states = array(
    '1' => 'Australian Capital Territory',
    '2' => 'Queensland',
    '3' => 'New South Wales',
    '4' => 'Tasmania',
    '5' => 'South Australia',
    '6' => 'Victoria',
    '7' => 'Western Australia',
    '8' => 'Northern Territory'
);
// nilai isian sebelumnya (kosong jika form baru dibuka)
$surname    = isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : '';
$email      = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$address    = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
$state      = isset($_POST['state']) ? $_POST['state'] : '0';
$sex        = isset($_POST['sex']) ? $_POST['sex'] : '';
$vegetarian = isset($_POST['vegetarian']);
?>
<form action="<?php echo htmlspecialchars(basename($_SERVER['PHP_SELF'])); ?>" method="POST">
    <fieldset>
        <legend>Person Details</legend>
        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname" value="<?php echo $surname; ?>">
        </div>
        <div class="field">
            <label for="email">Email Address</label>
            <input type="text" name="email" id="email" value="<?php echo $email; ?>">
        </div>
        <div class="field">
            <label for="passwd">Password</label>
            <input type="password" name="passwd" id="passwd">
        </div>
        <div class="field">
            <label for="address">Street Address</label>
            <textarea name="address" id="address" rows="3" cols="20"><?php echo $address; ?></textarea>
        </div>
        <div class="field">
            <label for="state">State</label>
            <select name="state" id="state">
                <option value="0">-- Choose your state --</option>
                <?php foreach ($states as $value => $name) { ?>
                <option value="<?php echo $value; ?>"<?php if ($state == $value) echo ' selected="selected"'; ?>><?php echo $name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="field">
            <input type="hidden" name="country" value="Australia">
        </div>
        <div class="field">
            <label>Gender</label>
            <input type="radio" name="sex" value="male"<?php if ($sex == 'male') echo ' checked="checked"'; ?>> Male
            <input type="radio" name="sex" value="female"<?php if ($sex == 'female') echo ' checked="checked"'; ?>> Female
        </div>
        <div class="field">
            <label for="vegetarian">Vegetarian?</label>
            <input type="checkbox" name="vegetarian" id="vegetarian" value="Yes"<?php if ($vegetarian) echo ' checked="checked"'; ?>>
        </div>
        <div class="field">
            <input type="submit" value="Submit" name="submit">
            <input type="reset" value="Reset" name="reset">
        </div>
    </fieldset>
</form>
