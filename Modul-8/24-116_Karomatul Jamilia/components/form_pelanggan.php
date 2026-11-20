<label>ID Pelanggan : </label>
<input type="text" name="id" maxlength="20" value="<?= htmlspecialchars($id) ?>" <?= $mode == "edit" ? "readonly" : "" ?>>
<span style="color: red;"><?= $error["id"] ?? "" ?></span>
<br><br>
<label>Nama : </label>
<input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
<span style="color: red;"><?= $error["nama"] ?? "" ?></span>
<br><br>
<label>Jenis Kelamin : </label>
<select name="jk">
    <option value="">-- Pilih --</option>
    <option value="L" <?= $jk == "L" ? "selected" : "" ?>>Laki-laki</option>
    <option value="P" <?= $jk == "P" ? "selected" : "" ?>>Perempuan</option>
</select>
<span style="color: red;"><?= $error["jk"] ?? "" ?></span>
<br><br>
<label>Telepon : </label>
<input type="text" name="telp" maxlength="12" value="<?= htmlspecialchars($telp) ?>">
<span style="color: red;"><?= $error["telp"] ?? "" ?></span>
<br><br>
<label>Alamat : </label>
<input type="text" name="alamat" value="<?= htmlspecialchars($alamat) ?>">
<span style="color: red;"><?= $error["alamat"] ?? "" ?></span>
<br><br>
<button type="submit" name="submit">Kirim</button>
<a href="index.php">Batal</a>
