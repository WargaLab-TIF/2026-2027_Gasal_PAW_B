<?php
// Helper: ambil nilai isian sebelumnya (langkah 7), aman dari XSS
if (!function_exists('old')) {
    function old($key)
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key], ENT_QUOTES, 'UTF-8') : '';
    }
}

$states = array(
    '1' => 'Australian Capital Territory',
    '2' => 'Queensland',
    '3' => 'Victoria',
    '4' => 'New South Wales',
    '5' => 'Tasmania',
    '6' => 'South Australia',
    '7' => 'Western Australia',
    '8' => 'Northern Territory'
);
$selState = isset($_POST['state']) ? $_POST['state'] : '-1';
$selSex   = isset($_POST['sex']) ? $_POST['sex'] : '';
?>
<form name="myForm" action="processData.php" method="POST">
  <fieldset>
    <legend>Person Details</legend>
    <div class="field">
      <label for="surname">Surname</label>
      <input type="text" name="surname" id="surname" size="31" value="<?php echo old('surname'); ?>"/>
    </div>
    <div class="field">
      <label for="email">Email address</label>
      <input type="text" name="email" id="email" size="31" value="<?php echo old('email'); ?>"/>
    </div>
    <div class="field">
      <label for="passwd">Password</label>
      <!-- password sengaja tidak diisi ulang demi keamanan -->
      <input type="password" name="passwd" id="passwd" size="31"/>
    </div>
    <div class="field">
      <label for="address">Street Address</label>
      <textarea name="address" id="address" rows="3" cols="22"><?php echo old('address'); ?></textarea>
    </div>
    <div class="field">
      <label for="state">State</label>
      <select name="state" id="state">
        <option value="-1" <?php if ($selState == '-1') echo 'selected'; ?>>[choose your state]</option>
        <?php foreach ($states as $val => $name): ?>
        <option value="<?php echo $val; ?>" <?php if ($selState == (string)$val) echo 'selected'; ?>><?php echo $name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="field">
      <input type="hidden" name="country" value="Australia"/>
    </div>
    <div class="field">
      <label for="sex">Gender</label>
      <input type="radio" name="sex" value="male" <?php if ($selSex == 'male') echo 'checked'; ?>/>Male
      <input type="radio" name="sex" value="female" <?php if ($selSex == 'female') echo 'checked'; ?>/>Female
    </div>
    <div class="field">
      <label for="vegetarian">Vegetarian?</label>
      <input type="checkbox" name="vegetarian" id="vegetarian" <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?>/>
    </div>
    <div class="field">
      <label>&nbsp;</label>
      <input type="submit" value="Submit" name="submit"/><input type="reset" value="Reset" name="reset"/>
    </div>
  </fieldset>
</form>
