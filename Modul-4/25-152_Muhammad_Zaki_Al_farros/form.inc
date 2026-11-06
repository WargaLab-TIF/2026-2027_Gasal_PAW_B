<form name="myForm" action="processData_form.php" method="POST">
    <div class="field">
        <label for="surname">Surname</label>
        <input type="text" name="surname" size="31"/>
        <?php if (isset($errors['surname'])) echo $errors['surname']; ?>
    </div>
    <div class="field">
        <label for="email">Email Address</label>
        <input type="text" name="email" size="31"/>
        <?php if (isset($errors['email'])) echo $errors['email']; ?>
    </div>
    <div class="field">
        <label for="passwd">Password</label>
        <input type="password" name="passwd" size="31"/>
        <?php if (isset($errors['passwd'])) echo $errors['passwd']; ?>
    </div>
    <div class="field">
        <label for="address">Street Address</label>
        <textarea name="address" rows="3" cols="22"></textarea>
        <?php if (isset($errors['address'])) echo $errors['address']; ?>
    </div>
    <div class="field">
        <label for="state">State</label>
        <select name="state">
            <option value="-1" selected>[Choose your state]</option>
            <option value="1">Australian Capital Territory</option>
            <option value="2">Queensland</option>
            <option value="3">Victoria</option>
            <option value="4">New South Wales</option>
            <option value="5">Tasmania</option>
            <option value="6">South Australia</option>
            <option value="7">Western Australia</option>
            <option value="8">Nothern Territory</option>
        </select>
        <?php if (isset($errors['state'])) echo $errors['state']; ?>
    </div>
    <div class="field">
        <input type="hidden" name="country" value="Australia">
    </div>
    <div class="field">
        <label for="sex">Gender</label>
        <input type="radio" name="sex" value="male"/>Male
        <input type="radio" name="sex" value="female"/>Female
        <?php if (isset($errors['sex'])) echo $errors['sex']; ?>
    </div>
    <div class="field">
        <label for="vegetarian">Vegetarian</label>
        <input type="checkbox" name="vegetarian"/>
    </div>
    <div class="field">
        <label>&nbsp</label>
        <input type="submit" value="Submit" name="submit"/><input type="reset" value="Reset" name="reset"/>
    </div>
</form>
