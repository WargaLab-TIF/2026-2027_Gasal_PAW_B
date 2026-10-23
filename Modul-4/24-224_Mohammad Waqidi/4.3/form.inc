
<fieldset>
    <legend>Person Details</legend>

    <form name="myForm" action="processData.php" method="post">

        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname" size="31"
                value="<?= htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
            <label for="email">Email Address</label>
            <input type="text" name="email" id="email" size="31"
                value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" size="31">
        </div>

        <div class="field">
            <label for="address">Street Address</label>
            <textarea name="address" id="address"
                rows="3" cols="22"><?= htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="field">
            <label for="state">State</label>
            <select name="state" id="state">
                <option value="-1"
                    <?= ($_POST['state'] ?? '-1') === '-1' ? 'selected' : '' ?>>
                    [Choose your state]
                </option>

                <option value="1" <?= ($_POST['state'] ?? '') === '1' ? 'selected' : '' ?>>Australian Capital Territory</option>
                <option value="2" <?= ($_POST['state'] ?? '') === '2' ? 'selected' : '' ?>>Queensland</option>
                <option value="3" <?= ($_POST['state'] ?? '') === '3' ? 'selected' : '' ?>>Victoria</option>
                <option value="4" <?= ($_POST['state'] ?? '') === '4' ? 'selected' : '' ?>>New South Wales</option>
                <option value="5" <?= ($_POST['state'] ?? '') === '5' ? 'selected' : '' ?>>Tasmania</option>
                <option value="6" <?= ($_POST['state'] ?? '') === '6' ? 'selected' : '' ?>>South Australia</option>
                <option value="7" <?= ($_POST['state'] ?? '') === '7' ? 'selected' : '' ?>>Western Australia</option>
                <option value="8" <?= ($_POST['state'] ?? '') === '8' ? 'selected' : '' ?>>Northern Territory</option>
            </select>
        </div>

        <input type="hidden" name="country" value="Australia">

        <div class="field">
            <label>Gender</label>

            <input type="radio" name="sex" value="Male" id="male"
                <?= ($_POST['sex'] ?? '') === 'Male' ? 'checked' : '' ?>>
            <label for="male">Male</label>

            <input type="radio" name="sex" value="Female" id="female"
                <?= ($_POST['sex'] ?? '') === 'Female' ? 'checked' : '' ?>>
            <label for="female">Female</label>
        </div>

        <div class="field">
            <label for="vegetarian">Vegetarian?</label>
            <input type="checkbox" name="vegetarian" id="vegetarian"
                value="Yes"
                <?= isset($_POST['vegetarian']) ? 'checked' : '' ?>>
        </div>

        <div class="field">
            <input type="submit" value="Submit" name="submit">
            <input type="reset" value="Reset" name="reset">
        </div>

    </form>
</fieldset>
