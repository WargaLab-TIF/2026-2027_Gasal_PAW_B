<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    <form name="myForm" action="form.php" method="POST">
        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" size="31"
            value="<?php echo htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES); ?>">
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input type="text" name="email" size="31"
            value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
        </div>

        <div class="field">
            <label for="passwd">Password</label>
            <input type="password" name="passwd" size="31">
        </div>

        <div class="field">
            <label for="addres">Street Address</label>
            <textarea name="addres" rows="3" cols="22"><?php
            echo htmlspecialchars($_POST['addres'] ?? '', ENT_QUOTES);
            ?></textarea>
        </div>

        <div class="field">
            <label for="state">State</label>
            <select name="state">
                <option value="-1" selected>[choose your state]</option>
                <option value="1">Australian Capital Territory</option>
                <option value="2">Queensland</option>
                <option value="3">Victoria</option>
                <option value="4">New South Wales</option>
                <option value="5">Tasmania</option>
                <option value="6">South Australia</option>
                <option value="7">Western Australia</option>
                <option value="8">Northern Territory</option>
            </select>
        </div>

        <div class="field">
            <input type="hidden" name="country" value="Australia">
        </div>

        <div class="field">
            <label>Gender</label>
            <input type="radio" name="sex" value="male">Male
            <input type="radio" name="sex" value="female">Female
        </div>

        <div class="field">
            <label for="vegetarian">Vegetarian</label>
            <input type="checkbox" id="vegetarian"
            name="vegetarian" value="Yes">
        </div>

        <div class="field">
            <input type="submit" value="Submit" name="submit">
            <input type="reset" value="Reset" name="reset">
        </div>
    </form>
</body>
</html>
-->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <legend>Person Details</legend>

    <form name="myForm" action="form.php" method="POST">
        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname" size="31"
                value="<?php echo htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES); ?>">
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input type="text" name="email" id="email" size="31"
                value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
        </div>

        <div class="field">
            <label for="passwd">Password</label>
            <input type="password" name="passwd" id="passwd" size="31">
        </div>

        <div class="field">
            <label for="addres">Street Address</label>
            <textarea name="addres" id="addres" rows="3" cols="22"><?php
                echo htmlspecialchars($_POST['addres'] ?? '', ENT_QUOTES);
            ?></textarea>
        </div>

        <div class="field">
            <label for="state">State</label>
            <select name="state" id="state">
                <option value="-1" selected>[choose your state]</option>
                <option value="1">Australian Capital Territory</option>
                <option value="2">Queensland</option>
                <option value="3">Victoria</option>
                <option value="4">New South Wales</option>
                <option value="5">Tasmania</option>
                <option value="6">South Australia</option>
                <option value="7">Western Australia</option>
                <option value="8">Northern Territory</option>
            </select>
        </div>

        <input type="hidden" name="country" value="Australia">

        <div class="field">
            <label>Gender</label>
            <input type="radio" name="sex" value="male">Male
            <input type="radio" name="sex" value="female">Female
        </div>

        <div class="field">
            <label for="vegetarian">Vegetarian</label>
            <input type="checkbox" id="vegetarian"
                name="vegetarian" value="Yes">
        </div>

        <div class="field">
            <input type="submit" value="Submit" name="submit">
            <input type="reset" value="Reset" name="reset">
        </div>
    </form>
</body>
</html>