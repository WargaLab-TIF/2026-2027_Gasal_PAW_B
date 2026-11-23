<form name="myForm" action="processData_form.php" method="POST">
<fieldset>
  <legend>Person Details</legend>

  <div class="field">
    <label for="surname">Surname</label>
    <input type="text" name="surname" id="surname" size="31"
           value="<?= old('surname') ?>" />
    <?= showError($errors, 'surname') ?>
  </div>

  <div class="field">
    <label for="email">Email address</label>
    <input type="text" name="email" id="email" size="31"
           value="<?= old('email') ?>" />
    <?= showError($errors, 'email') ?>
  </div>

  <div class="field">
    <label for="passwd">Password</label>
    <input type="password" name="passwd" id="passwd" size="31" />
    <?= showError($errors, 'passwd') ?>
  </div>

  <div class="field">
    <label for="address">Street Address</label>
    <textarea name="address" id="address" rows="3" cols="22"><?= old('address') ?></textarea>
    <?= showError($errors, 'address') ?>
  </div>

  <div class="field">
    <label for="state">State</label>
    <select name="state" id="state">
      <option value="-1" <?= selected_if('state', '-1', true) ?>>[choose your state]</option>
      <option value="1" <?= selected_if('state', '1') ?>>Australian Capital Territory</option>
      <option value="2" <?= selected_if('state', '2') ?>>Queensland</option>
      <option value="3" <?= selected_if('state', '3') ?>>Victoria</option>
      <option value="4" <?= selected_if('state', '4') ?>>New South Wales</option>
      <option value="5" <?= selected_if('state', '5') ?>>Tasmania</option>
      <option value="6" <?= selected_if('state', '6') ?>>South Australia</option>
      <option value="7" <?= selected_if('state', '7') ?>>Western Australia</option>
      <option value="8" <?= selected_if('state', '8') ?>>Northern Territory</option>
    </select>
    <?= showError($errors, 'state') ?>
  </div>

  <input type="hidden" name="country" value="Australia" />

  <div class="field">
    <label>Gender</label>
    <input type="radio" name="sex" value="male" id="male"
           <?= checked_if('sex', 'male') ?> /><label for="male">Male</label>
    <input type="radio" name="sex" value="female" id="female"
           <?= checked_if('sex', 'female') ?> /><label for="female">Female</label>
    <?= showError($errors, 'sex') ?>
  </div>

  <div class="field">
    <label for="vegetarian">Vegetarian?</label>
    <input type="checkbox" name="vegetarian" id="vegetarian"
           <?= checked_if('vegetarian', 'on') ?> />
  </div>

  <div class="field">
    <label>&nbsp;</label>
    <input type="submit" value="Submit" name="submit" />
    <input type="reset" value="Reset" name="reset" />
  </div>
</fieldset>
</form>