<style>
    body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }
    .form-container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 520px; }
    h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
    div.field { margin-bottom: 14px; }
    label { display: inline-block; width: 140px; font-weight: bold; vertical-align: top; }
    input[type="text"], input[type="email"], input[type="password"], textarea, select {
        width: 260px; padding: 6px; border: 1px solid #ccc; border-radius: 4px;
    }
    textarea { height: 60px; }
    input[type="submit"], input[type="reset"] {
        padding: 8px 20px; margin-right: 10px; border: none; border-radius: 4px; cursor: pointer;
    }
    input[type="submit"] { background-color: #4CAF50; color: white; }
    input[type="reset"] { background-color: #f44336; color: white; }
    .error-msg { color: #c62828; font-size: 0.9em; margin-left: 145px; display: block; }
</style>

<div class="form-container">
    <h1>Register</h1>
    <h2>Person Details</h2>
    <form name="myForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="field">
            <label for="surname">Surname:</label>
            <input type="text" name="surname" size="25"
                   value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>" />
            <?php if (isset($errors['surname'])) echo '<span class="error-msg">'.$errors['surname'].'</span>'; ?>
        </div>

        <div class="field">
            <label for="email">Email address:</label>
            <input type="text" name="email" size="25"
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
            <?php if (isset($errors['email'])) echo '<span class="error-msg">'.$errors['email'].'</span>'; ?>
        </div>

        <div class="field">
            <label for="passwd">Password:</label>
            <input type="password" name="passwd" size="25" />
            <?php if (isset($errors['passwd'])) echo '<span class="error-msg">'.$errors['passwd'].'</span>'; ?>
        </div>

        <div class="field">
            <label for="address">Street Address:</label>
            <textarea name="address" rows="3" cols="25"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
            <?php if (isset($errors['address'])) echo '<span class="error-msg">'.$errors['address'].'</span>'; ?>
        </div>

        <div class="field">
            <label for="state">State:</label>
            <select name="state">
                <option value="-1">--Please choose your state--</option>
                <?php
                $states = [
                    '1' => 'Australian Capital Territory',
                    '2' => 'Queensland',
                    '3' => 'Victoria',
                    '4' => 'New South Wales',
                    '5' => 'Tasmania',
                    '6' => 'South Australia',
                    '7' => 'Western Australia',
                    '8' => 'Northern Territory'
                ];
                $selectedState = isset($_POST['state']) ? $_POST['state'] : '-1';
                foreach ($states as $val => $label) {
                    $sel = ($selectedState == $val) ? 'selected' : '';
                    echo "<option value=\"$val\" $sel>$label</option>";
                }
                ?>
            </select>
            <?php if (isset($errors['state'])) echo '<span class="error-msg">'.$errors['state'].'</span>'; ?>
        </div>

        <div class="field">
            <input type="hidden" name="country" value="Australia" />
        </div>

        <div class="field">
            <label for="sex">Gender:</label>
            <input type="radio" name="sex" value="male"
                <?php echo (isset($_POST['sex']) && $_POST['sex'] == 'male') ? 'checked' : ''; ?> />Male
            <input type="radio" name="sex" value="female"
                <?php echo (isset($_POST['sex']) && $_POST['sex'] == 'female') ? 'checked' : ''; ?> />Female
            <?php if (isset($errors['sex'])) echo '<span class="error-msg">'.$errors['sex'].'</span>'; ?>
        </div>

        <div class="field">
            <label for="vegetarian">Vegetarian?</label>
            <input type="checkbox" name="vegetarian"
                <?php echo (isset($_POST['vegetarian'])) ? 'checked' : ''; ?> />
        </div>

        <div class="field">
            <input type="submit" name="submit" value="Submit" />
            <input type="reset" name="reset" value="Reset" />
        </div>
    </form>
</div>
