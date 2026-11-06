<fieldset>
    <legend>Person Details</legend>

    <form name="myForm" action="processData.php" method="POST">
        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" id="surname" name="surname" size="31"
                value="<?= htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"/>
        </div>
        <div class="field">
            <label for="email">Email address</label>
            <input type="text" id="email" name="email" size="31"
                value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"/>
        </div>
        <div class="field">
            <label for="passwd">Password</label>
            <input type="password" id="passwd" name="passwd" size="31"/>
        </div>
        <div class="field">
            <label for="address">Street Address</label>
            <textarea id="address" name="address" rows="3" cols="22"><?= htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="field">
            <label for="state">State</label>
            <select id="state" name="state">
                <?php
                $states = array(
                    '-1' => '[choose your state]',
                    '1' => 'Australian Capital Territory',
                    '2' => 'Queensland',
                    '3' => 'Victoria',
                    '4' => 'New South Wales',
                    '5' => 'Tasmania',
                    '6' => 'South Australia',
                    '7' => 'Western Australia',
                    '8' => 'Northern Territory'
                );

                foreach ($states as $key => $value) {
                    $selected = (($_POST['state'] ?? '-1') == $key)
                        ? 'selected' : '';

                    echo "<option value=\"$key\" $selected>$value</option>";
                }
                ?>
            </select>
        </div>

        <input type="hidden" name="country" value="Australia"/>

        <div class="field">
            <label>Gender</label>
            <input type="radio" name="sex" value="male"
                <?= (($_POST['sex'] ?? '') == 'male') ? 'checked' : '' ?>/> Male

            <input type="radio" name="sex" value="female"
                <?= (($_POST['sex'] ?? '') == 'female') ? 'checked' : '' ?>/> Female
        </div>
        <div class="field">
            <label for="vegetarian">Vegetarian?</label>
            <input type="checkbox" id="vegetarian" name="vegetarian" value="Yes"
                <?= isset($_POST['vegetarian']) ? 'checked' : '' ?>/>
        </div>
        <div class="field">
            <label>&nbsp;</label>
            <input type="submit" value="Submit" name="submit"/>
            <input type="reset" value="Reset" name="reset"/>
        </div>
    </form>
</fieldset>