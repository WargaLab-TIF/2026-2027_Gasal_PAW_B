<input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user ?? "") ?>">

<label>Username:</label><br>
<input type="text" name="username" value="<?= htmlspecialchars($username_val ?? "") ?>">
<span style="color: red;"><?= $error["username"] ?? "" ?></span><br><br>

<label>Password <?= ($is_edit ?? false) ? "(Kosongkan jika tidak diubah)" : "" ?>:</label><br>
<input type="password" name="password" value="">
<span style="color: red;"><?= $error["password"] ?? "" ?></span><br><br>

<label>Nama Lengkap:</label><br>
<input type="text" name="nama" value="<?= htmlspecialchars($nama ?? "") ?>">
<span style="color: red;"><?= $error["nama"] ?? "" ?></span><br><br>

<label>Alamat:</label><br>
<input type="text" name="alamat" value="<?= htmlspecialchars($alamat ?? "") ?>">
<span style="color: red;"><?= $error["alamat"] ?? "" ?></span><br><br>

<label>No. HP:</label><br>
<input type="text" name="hp" value="<?= htmlspecialchars($hp ?? "") ?>">
<span style="color: red;"><?= $error["hp"] ?? "" ?></span><br><br>

<label>Level:</label><br>
<select name="level">
    <option value="">-- Pilih Level --</option>
    <option value="1" <?= (($level ?? "") == 1) ? "selected" : "" ?>>1 - Owner</option>
    <option value="2" <?= (($level ?? "") == 2) ? "selected" : "" ?>>2 - Kasir</option>
</select>
<span style="color: red;"><?= $error["level"] ?? "" ?></span><br><br>

<button type="submit" name="submit">Simpan</button>
<a href="user.php">Batal</a>
