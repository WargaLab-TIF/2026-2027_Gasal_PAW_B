<?php
// isian sebelumnya (jika ada) supaya form tidak kosong lagi saat error
$surname = $_POST['surname'] ?? '';
$email   = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$state   = $_POST['state'] ?? '-1';
$sex     = $_POST['sex'] ?? '';
$veg     = isset($_POST['vegetarian']);
?>
<form name="myForm" action="processData_form.php" method="POST">
  <fieldset>
    <legend>Person Details</legend>
    <div class="field">
      <label for="surname">Surname</label>
      <input type="text" id="surname" name="surname" size="31" value="<?php echo htmlspecialchars($surname); ?>"/>
    </div>
    <div class="field">
      <label for="email">Email address</label>
      <input type="text" id="email" name="email" size="31" value="<?php echo htmlspecialchars($email); ?>"/>
    </div>
    <div class="field">
      <label for="passwd">Password</label>
      <input type="password" id="passwd" name="passwd" size="31"/>
    </div>
    <div class="field">
      <label for="address">Street Address</label>
      <textarea id="address" name="address" rows="3" cols="22"><?php echo htmlspecialchars($address); ?></textarea>
    </div>
    <div class="field">
      <label for="state">State</label>
      <select id="state" name="state">
      <option value="-1" <?php if ($state == '-1') echo 'selected'; ?>>[choose your state]</option>
      <option value="1" <?php if ($state == '1') echo 'selected'; ?>>Australian Capital Territory</option>
      <option value="2" <?php if ($state == '2') echo 'selected'; ?>>Queensland</option>
      <option value="3" <?php if ($state == '3') echo 'selected'; ?>>Victoria</option>
      <option value="4" <?php if ($state == '4') echo 'selected'; ?>>New South Wales</option>
      <option value="5" <?php if ($state == '5') echo 'selected'; ?>>Tasmania</option>
      <option value="6" <?php if ($state == '6') echo 'selected'; ?>>South Australia</option>
      <option value="7" <?php if ($state == '7') echo 'selected'; ?>>Western Australia</option>
      <option value="8" <?php if ($state == '8') echo 'selected'; ?>>Northern Territory</option>
      </select>
    </div>
    <div class="field">
      <input type="hidden" name="country" value="Australia">
    </div>
    <div class="field">
      <label>Gender</label>
      <input type="radio" id="male" name="sex" value="male" <?php if ($sex == 'male') echo 'checked'; ?>/><label for="male">Male</label>
      <input type="radio" id="female" name="sex" value="female" <?php if ($sex == 'female') echo 'checked'; ?>/><label for="female">Female</label>
    </div>
    <div class="field">
      <label for="vegetarian">Vegetarian?</label>
      <input type="checkbox" id="vegetarian" name="vegetarian" <?php if ($veg) echo 'checked'; ?>/>
    </div>
    <div class="field">
      <input type="submit" value="Submit" name="submit"/><input type="reset" value="Reset" name="reset"/>
    </div>
  </fieldset>
</form>
