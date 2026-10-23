<?php
$surname = htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
$address = htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');
$state = $_POST['state'] ?? 'NSW';
$gender = $_POST['gender'] ?? '';
$vegetarian = isset($_POST['vegetarian']);
?>

<h2>Form Data Pribadi</h2>

<form action="processData_form.php" method="POST">
    <label>Surname:</label><br>
    <input type="text" name="surname" value="<?= $surname ?>"><br><br>

    <label>Email address:</label><br>
    <input type="email" name="email" value="<?= $email ?>"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <label>Street Address:</label><br>
    <textarea name="address"><?= $address ?></textarea><br><br>

    <label>State:</label><br>
    <select name="state">
        <option value="NSW" <?= $state == 'NSW' ? 'selected' : '' ?>>New South Wales</option>
        <option value="VIC" <?= $state == 'VIC' ? 'selected' : '' ?>>Victoria</option>
        <option value="QLD" <?= $state == 'QLD' ? 'selected' : '' ?>>Queensland</option>
        <option value="WA" <?= $state == 'WA' ? 'selected' : '' ?>>Western Australia</option>
    </select><br><br>

    <input type="hidden" name="country" value="Australia">

    <label>Gender:</label><br>
    <input type="radio" name="gender" value="Male" <?= $gender == 'Male' ? 'checked' : '' ?>> Male
    <input type="radio" name="gender" value="Female" <?= $gender == 'Female' ? 'checked' : '' ?>> Female
    <br><br>

    <input type="checkbox" name="vegetarian" value="Yes" <?= $vegetarian ? 'checked' : '' ?>>
    Vegetarian?<br><br>

    <input type="submit" value="Submit">
    <input type="reset" value="Reset">
</form>