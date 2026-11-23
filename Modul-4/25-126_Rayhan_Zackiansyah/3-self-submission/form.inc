<form name="MyForm" action="processData_form.php" method="POST">
    <table>
        <tr>
            <td>Surname</td>
            <td><input type="text" name="surname"></td>
        </tr>

        <tr>
            <td>Email</td>
            <td><input type="text" name="email"></td>
        </tr>

        <tr>
            <td>Password</td>
            <td><input type="password" name="passwd"></td>
        </tr>

        <tr>
            <td>Address</td>
            <td><textarea name="address"></textarea></td>
        </tr>

        <tr>
            <td>Country</td>
            <td>
                <input type="hidden" name="country" value="Australia">
                Australia
            </td>
        </tr>

        <tr>
            <td>State</td>
            <td>
                <select name="state">
                    <option value="-1">Select State</option>
                    <option value="1">State 1</option>
                    <option value="2">State 2</option>
                    <option value="3">State 3</option>
                    <option value="4">State 4</option>
                    <option value="5">State 5</option>
                    <option value="6">State 6</option>
                    <option value="7">State 7</option>
                    <option value="8">State 8</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Sex</td>
            <td>
                <input type="radio" name="sex" value="male"> Male
                <input type="radio" name="sex" value="female"> Female
            </td>
        </tr>

        <tr>
            <td>Vegetarian</td>
            <td>
                <input type="checkbox" name="vegetarian" value="Yes">
                Yes
            </td>
        </tr>

        <tr>
            <td>
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </td>
        </tr>
    </table>
</form>