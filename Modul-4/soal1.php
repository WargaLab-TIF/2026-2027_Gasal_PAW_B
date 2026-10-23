<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Person Details</title>
</head>
<body>
    <form action="processData.php" method="POST">
        <fieldset>
            <legend>Person Details</legend>

            <label>Surname</label><br>
            <input type="text" name="surname"><br><br>

            <label>Email Address</label><br>
            <input type="text" name="email"><br><br>

            <label>Password</label><br>
            <input type="password" name="password"><br><br>

            <label>Street Address</label><br>
            <textarea name="address" rows="3" cols="22"></textarea><br><br>

            <label>State</label><br>
            <select name="state">
                <option value="-1">Choose your state</option>
                <option value="1">Australian Capital Territory</option>
                <option value="2">Queensland</option>
                <option value="3">Victoria</option>
                <option value="4">New South Wales</option>
                <option value="5">Tasmania</option>
                <option value="6">South Australia</option>
                <option value="7">Western Australia</option>
                <option value="8">Northern Territory</option>
            </select><br><br>

            <input type="hidden" name="country" value="Australia">

            <label>Gender</label><br>
            <input type="radio" name="gender" value="Male"> Male
            <input type="radio" name="gender" value="Female"> Female
            <br><br>

            <label>Vegetarian?</label>
            <input type="checkbox" name="vegetarian" value="Yes">
            <br><br>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </fieldset>
    </form>
</body>
</html>
