<?php

/*
PENGAMATAN 4.3.2 langkah 8 (form dengan isian sebelumnya)
- Saat ada error, form tampil kembali dengan data yang tadi diisi (surname, email,
  alamat, state, gender, vegetarian), karena nilai diambil dari $_POST.
- Perbedaan dengan langkah 6: pengguna cukup memperbaiki field yang salah, tidak
  perlu mengetik ulang semuanya.
- Password sengaja tidak diisi ulang demi keamanan. Nilai di-escape dengan
  htmlspecialchars untuk mencegah XSS.
*/

function old($name) {
    return isset($_POST[$name]) ? htmlspecialchars($_POST[$name], ENT_QUOTES, 'UTF-8') : '';
}

function err($name) {
    global $errors;
    return isset($errors[$name]) ? '<span class="err">' . htmlspecialchars($errors[$name]) . '</span>' : '';
}

$states = array(
    1 => 'Australian Capital Territory', 2 => 'Queensland', 3 => 'Victoria',
    4 => 'New South Wales', 5 => 'Tasmania', 6 => 'South Australia',
    7 => 'Western Australia', 8 => 'Northern Territory'
);

$selState = isset($_POST['state']) ? $_POST['state'] : '-1';

$selSex   = isset($_POST['sex']) ? $_POST['sex'] : '';

?>

<h2>Register</h2>

<fieldset>

  <legend>Person Details</legend>

  <form name="myForm" action="form.php" method="POST">

    <div class="field">
      <label for="surname">Surname</label>
      <input type="text" name="surname" size="31" value="<?php echo old('surname'); ?>"/>
      <?php echo err('surname'); ?>
    </div>

    <div class="field">
      <label for="email">Email address</label>
      <input type="text" name="email" size="31" value="<?php echo old('email'); ?>"/>
      <?php echo err('email'); ?>
    </div>

    <div class="field">
      <label for="passwd">Password</label>
      <input type="password" name="passwd" size="31"/>
      <?php echo err('passwd'); ?>
    </div>

    <div class="field">
      <label for="address">Street Address</label>
      <textarea name="address" rows="3" cols="22"><?php echo old('address'); ?></textarea>
      <?php echo err('address'); ?>
    </div>

    <div class="field">
      <label for="state">State</label>
      <select name="state">
        <option value="-1" <?php if ($selState === '-1') echo 'selected'; ?>>[choose your state]</option>
        <?php foreach ($states as $val => $label): ?>
          <option value="<?php echo $val; ?>" <?php if ((string)$val === $selState) echo 'selected'; ?>><?php echo $label; ?></option>
        <?php endforeach; ?>
      </select>
      <?php echo err('state'); ?>
    </div>

    <div class="field">
      <input type="hidden" name="country" value="Australia"/>
    </div>

    <div class="field">
      <label for="sex">Gender</label>
      <input type="radio" name="sex" value="male" <?php if ($selSex === 'male') echo 'checked'; ?>/>Male
      <input type="radio" name="sex" value="female" <?php if ($selSex === 'female') echo 'checked'; ?>/>Female
      <?php echo err('sex'); ?>
    </div>

    <div class="field">
      <label for="vegetarian">Vegetarian?</label>
      <input type="checkbox" name="vegetarian" <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?>/>
    </div>

    <div class="field">
      <label>&nbsp;</label>
      <input type="submit" value="Submit" name="submit"/>
      <input type="reset" value="Reset" name="reset"/>
    </div>

  </form>
  
</fieldset>
