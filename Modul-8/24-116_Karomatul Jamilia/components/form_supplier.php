<input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
<label>Nama Supplier : </label>
<input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
<span style="color: red;"><?= $error["nama"] ?? "" ?></span>
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
