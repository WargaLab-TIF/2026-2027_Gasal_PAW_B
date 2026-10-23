<form action="processData_form.php" method="POST">
    <fieldset>
        <legend>Person Details</legend>

        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname"
                value="<?php echo htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input type="text" name="email" id="email"
                value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"/>
        </div>

        <div class="field">
            <label for="address">Street Address</label>
            <textarea name="address" id="address" rows="3" cols="22"><?php
                echo htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');
            ?></textarea>
        </div>

        <div class="field">
            <label for="state">State</label>
            <select name="state" id="state">
                <option value="">Choose your state</option>
                <?php
                $states = array(
                    'Australian Capital Territory',
                    'Queensland',
                    'New South Wales',
                    'Victoria',
                    'South Australia',
                    'Western Australia',
                    'Tasmania',
                    'Northern Territory'
                );

                foreach ($states as $state)
                {
                    $selected = (($_POST['state'] ?? '') == $state)
                        ? 'selected' : '';

                    echo '<option value="' .
                        htmlspecialchars($state, ENT_QUOTES, 'UTF-8') .
                        '" ' . $selected . '>' .
                        htmlspecialchars($state, ENT_QUOTES, 'UTF-8') .
                        '</option>';
                }
                ?>
            </select>
        </div>

        <div class="field">
            <input type="hidden" name="country" value="Australia"/>
        </div>

        <div class="field">
            <label>Gender</label>
            <input type="radio" name="gender" value="Male"
                <?php if (($_POST['gender'] ?? '') == 'Male') echo 'checked'; ?>/>Male

            <input type="radio" name="gender" value="Female"
                <?php if (($_POST['gender'] ?? '') == 'Female') echo 'checked'; ?>/>Female
        </div>

        <div class="field">
            <label for="vegetarian">Vegetarian?</label>
            <input type="checkbox" name="vegetarian" id="vegetarian" value="Yes"
                <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?>/>
        </div>

        <div class="field">
            <label></label>
            <input type="submit" name="submit" value="Submit"/>
            <input type="reset" name="reset" value="Reset"/>
        </div>
    </fieldset>
</form>