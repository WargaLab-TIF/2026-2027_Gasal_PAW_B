<?php
$surname = htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
$address = htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');
$state = $_POST['state'] ?? '-1';
$gender = $_POST['gender'] ?? '';
$vegetarian = isset($_POST['vegetarian']);
?>

<h2>Form Data Pribadi</h2>

<form action="processData_form.php" method="POST">

    <div class="field">
        <label for="surname">Surname</label><br>
        <input type="text" name="surname" id="surname"
               value="<?= $surname ?>">
    </div>
    <br>

    <div class="field">
        <label for="email">Email address</label><br>
        <input type="email" name="email" id="email"
               value="<?= $email ?>">
    </div>
    <br>

    <div class="field">
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password">
    </div>
    <br>

    <div class="field">
        <label for="address">Street Address</label><br>
        <textarea name="address" id="address"><?= $address ?></textarea>
    </div>
    <br>

    <div class="field">
        <label for="state">State</label><br>
        <select name="state" id="state">
            <option value="-1" <?= $state == '-1' ? 'selected' : '' ?>>[choose your state]</option>
            <option value="1" <?= $state == '1' ? 'selected' : '' ?>>Australian Capital Territory</option>
            <option value="2" <?= $state == '2' ? 'selected' : '' ?>>Queensland</option>
            <option value="3" <?= $state == '3' ? 'selected' : '' ?>>Victoria</option>
            <option value="4" <?= $state == '4' ? 'selected' : '' ?>>New South Wales</option>
            <option value="5" <?= $state == '5' ? 'selected' : '' ?>>Tasmania</option>
            <option value="6" <?= $state == '6' ? 'selected' : '' ?>>South Australia</option>
            <option value="7" <?= $state == '7' ? 'selected' : '' ?>>Western Australia</option>
            <option value="8" <?= $state == '8' ? 'selected' : '' ?>>Northern Territory</option>
        </select>
    </div>
    <br>

    <input type="hidden" name="country" value="Australia">

    <div class="field">
        <label>Gender</label><br>
        <input type="radio" name="gender" value="Male"
            <?= $gender == 'Male' ? 'checked' : '' ?>> Male

        <input type="radio" name="gender" value="Female"
            <?= $gender == 'Female' ? 'checked' : '' ?>> Female
    </div>
    <br>

    <div class="field">
        <input type="checkbox" name="vegetarian" value="Yes"
            <?= $vegetarian ? 'checked' : '' ?>>
        Vegetarian?
    </div>
    <br>

    <input type="submit" value="Submit">
    <input type="reset" value="Reset">

</form>