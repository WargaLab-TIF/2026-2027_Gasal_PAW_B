<fieldset>
    <legend>person details</legend>

    <form name="form" action="register.php" method="POST">

        <div class="field">
            <label for="surname">surname</label>
            <input type="text" name="surname" size="31"
                value="<?php echo htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
        </div>

        <div class="field">
            <label for="email">email address</label>
            <input type="text" name="email" size="31"
                value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
        </div>

        <div class="field">
            <label for="password">password</label>
            <input type="password" name="password" size="31"/>
        </div>

        <div class="field">
            <label for="address">street Address</label>
            <textarea name="address" rows="3" cols="22"><?php
                echo htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');
            ?></textarea>
        </div>

        <div class="field">
            <label for="state">state</label>
            <select name="state">
                <option value="-1" <?php echo (($_POST['state'] ?? '-1') == '-1') ? 'selected' : ''; ?>>[choose your state]</option>
                <option value="1" <?php echo (($_POST['state'] ?? '') == '1') ? 'selected' : ''; ?>>Australian Capital Territory</option>
                <option value="2" <?php echo (($_POST['state'] ?? '') == '2') ? 'selected' : ''; ?>>Queensland</option>
                <option value="3" <?php echo (($_POST['state'] ?? '') == '3') ? 'selected' : ''; ?>>Victoria</option>
                <option value="4" <?php echo (($_POST['state'] ?? '') == '4') ? 'selected' : ''; ?>>New South Wales</option>
                <option value="5" <?php echo (($_POST['state'] ?? '') == '5') ? 'selected' : ''; ?>>Tasmania</option>
                <option value="6" <?php echo (($_POST['state'] ?? '') == '6') ? 'selected' : ''; ?>>South Australia</option>
                <option value="7" <?php echo (($_POST['state'] ?? '') == '7') ? 'selected' : ''; ?>>Western Australia</option>
                <option value="8" <?php echo (($_POST['state'] ?? '') == '8') ? 'selected' : ''; ?>>Northern Territory</option>
            </select>
        </div>

        <input type="hidden" name="country" value="Australia">

        <div class="field">
            <label for="sex">Gender</label>
            <input type="radio" name="sex" value="male"
                <?php echo (($_POST['sex'] ?? '') == 'male') ? 'checked' : ''; ?>>Male

            <input type="radio" name="sex" value="female"
                <?php echo (($_POST['sex'] ?? '') == 'female') ? 'checked' : ''; ?>>Female
        </div>

        <div class="field">
            <label for="vegetarian">Vegetarian?</label>
            <input type="checkbox" name="vegetarian" value="Yes"
                <?php echo isset($_POST['vegetarian']) ? 'checked' : ''; ?>>
        </div>

        <div class="field">
            <label>&nbsp;</label>
            <input type="submit" value="Submit" name="submit"/>
            <input type="reset" value="Reset" name="reset"/>
        </div>

    </form>
</fieldset>