<form name="myForm" action="processData_form.php" method="POST">
  <div class="field">
    <label for="surname">Surname</label>
    <input type="text" name="surname" size="31"
      value="<?php if (isset($_POST['surname'])) echo htmlspecialchars($_POST['surname']); ?>"/>
  </div>
  <div class="field">
    <label for="email">Email address</label>
    <input type="text" name="email" size="31"
      value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>"/>
  </div>
  <div class="field">
    <label for="passwd">Password</label>
    <input type="Password" name="passwd"/>
  </div>
  <div class="field">
    <label for="address">Street Address</label>
    <textarea name="address" rows="3" cols="22"><?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?></textarea>
  </div>
  <div class="field">
    <label for="state">States</label>
    <select name="state">
      <?php $st = isset($_POST['state']) ? $_POST['state'] : '-1'; ?>
      <option value="-1" <?php if ($st == '-1') echo 'selected'; ?>>[choose your state]</option>
      <option value="1" <?php if ($st == '1') echo 'selected'; ?>>Australian Capital Territory</option>
      <option value="2" <?php if ($st == '2') echo 'selected'; ?>>Queensland</option>
      <option value="3" <?php if ($st == '3') echo 'selected'; ?>>Victoria</option>
      <option value="4" <?php if ($st == '4') echo 'selected'; ?>>New South Wales</option>
      <option value="5" <?php if ($st == '5') echo 'selected'; ?>>Tasmania</option>
      <option value="6" <?php if ($st == '6') echo 'selected'; ?>>South Australia</option>
      <option value="7" <?php if ($st == '7') echo 'selected'; ?>>Western Australia</option>
      <option value="8" <?php if ($st == '8') echo 'selected'; ?>>Nothern Territory</option>
    </select>
  </div>
  <div class="field">
    <input type="hidden" name="country" value="Australia">
    <label for="sex">Gender</label>
    <input type="radio" name="sex" value="male"
      <?php if (isset($_POST['sex']) && $_POST['sex'] == 'male') echo 'checked'; ?>/>Male
    <input type="radio" name="sex" value="Female"
      <?php if (isset($_POST['sex']) && $_POST['sex'] == 'Female') echo 'checked'; ?>/>Female
  </div>
  <div class="field">
    <label for="vegetarian">Vegetarian?</label>
    <input type="checkbox" name="vegetarian"
      <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?>>
  </div>
  <div class="field">
    <label>&nbsp;</label>
    <input type="submit" value="Submit" name="submit"/><input type="reset" value="Reset" name="reset"/>
  </div>
</form>
