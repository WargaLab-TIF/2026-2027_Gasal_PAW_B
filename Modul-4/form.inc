<fieldset>
    <legend>Person Details</legend>

    <form action="form.php" method="POST">
        <label>Surname</label><br>
        <input type="text" name="surname"
            value="<?= htmlspecialchars($_POST['surname'] ?? '') ?>">
        <br><br>

        <label>Email Address</label><br>
        <input type="text" name="email"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <br><br>

        <label>Password</label><br>
        <input type="password" name="password">
        <br><br>

        <label>Street Address</label><br>
        <textarea name="address" rows="3" cols="22"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
        <br><br>

        <label>State</label><br>
        <select name="state">
            <?php
            $states = [
                '-1' => 'Choose your state',
                '1' => 'Australian Capital Territory',
                '2' => 'Queensland',
                '3' => 'Victoria',
                '4' => 'New South Wales',
                '5' => 'Tasmania',
                '6' => 'South Australia',
                '7' => 'Western Australia',
                '8' => 'Northern Territory'
            ];

            foreach ($states as $value => $name) {
                $selected = ($_POST['state'] ?? '-1') == $value
                    ? 'selected' : '';

                echo '<option value="' . $value . '" ' . $selected . '>' .
                     htmlspecialchars($name) . '</option>';
            }
            ?>
        </select>
        <br><br>

        <input type="hidden" name="country" value="Australia">

        <label>Gender</label><br>
        <input type="radio" name="gender" value="Male"
            <?= ($_POST['gender'] ?? '') === 'Male' ? 'checked' : '' ?>> Male

        <input type="radio" name="gender" value="Female"
            <?= ($_POST['gender'] ?? '') === 'Female' ? 'checked' : '' ?>> Female
        <br><br>

        <label>Vegetarian?</label>
        <input type="checkbox" name="vegetarian" value="Yes"
            <?= isset($_POST['vegetarian']) ? 'checked' : '' ?>>
        <br><br>

        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>
</fieldset>
