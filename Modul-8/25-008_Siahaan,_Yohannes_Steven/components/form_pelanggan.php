<label>ID Pelanggan:</label><br>
<input type="text" name="id" value="<?= htmlspecialchars($id ?? "") ?>" <?= ($is_edit ?? false) ? "readonly" : "" ?>>
<span style="color: red;"><?= $error["id"] ?? "" ?></span><br><br>

<label>Nama Pelanggan:</label><br>
<input type="text" name="nama" value="<?= htmlspecialchars($nama ?? "") ?>">
<span style="color: red;"><?= $error["nama"] ?? "" ?></span><br><br>

<label>Jenis Kelamin:</label><br>
<select name="jenis_kelamin">
    <option value="">-- Pilih Jenis Kelamin --</option>
    <option value="L" <?= (($jenis_kelamin ?? "") == "L") ? "selected" : "" ?>>Laki-laki (L)</option>
    <option value="P" <?= (($jenis_kelamin ?? "") == "P") ? "selected" : "" ?>>Perempuan (P)</option>
</select>
<span style="color: red;"><?= $error["jenis_kelamin"] ?? "" ?></span><br><br>

<label>Telepon:</label><br>
<input type="text" name="telp" value="<?= htmlspecialchars($telp ?? "") ?>">
<span style="color: red;"><?= $error["telp"] ?? "" ?></span><br><br>

<label>Alamat:</label><br>
<textarea name="alamat"><?= htmlspecialchars($alamat ?? "") ?></textarea>
<span style="color: red;"><?= $error["alamat"] ?? "" ?></span><br><br>

<button type="submit" name="submit">Simpan</button>
<a href="pelanggan.php">Batal</a>
