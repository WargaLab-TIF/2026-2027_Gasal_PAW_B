<input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
<label>Username : </label>
<input type="text" name="username" maxlength="30" value="<?= htmlspecialchars($username) ?>">
<span style="color: red;"><?= $error["username"] ?? "" ?></span>
<br><br>
<label>Password : </label>
<input type="password" name="password">
<?php if ($mode == "edit") { ?><small>(kosongkan jika tidak diubah)</small><?php } ?>
<span style="color: red;"><?= $error["password"] ?? "" ?></span>
<br><br>
<label>Nama : </label>
<input type="text" name="nama" maxlength="50" value="<?= htmlspecialchars($nama) ?>">
<span style="color: red;"><?= $error["nama"] ?? "" ?></span>
<br><br>
<label>Alamat : </label>
<input type="text" name="alamat" maxlength="150" value="<?= htmlspecialchars($alamat) ?>">
<br><br>
<label>No. HP : </label>
<input type="text" name="hp" maxlength="20" value="<?= htmlspecialchars($hp) ?>">
<span style="color: red;"><?= $error["hp"] ?? "" ?></span>
<br><br>
<label>Level : </label>
<select name="level">
    <option value="">-- Pilih Level --</option>
    <option value="1" <?= $level == "1" ? "selected" : "" ?>>1 - Owner</option>
    <option value="2" <?= $level == "2" ? "selected" : "" ?>>2 - Kasir</option>
</select>
<span style="color: red;"><?= $error["level"] ?? "" ?></span>
<br><br>
<button type="submit" name="submit">Kirim</button>
<a href="index.php">Batal</a>
