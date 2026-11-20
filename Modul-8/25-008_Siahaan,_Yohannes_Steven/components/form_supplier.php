<input type="hidden" name="id" value="<?= htmlspecialchars($id ?? "") ?>">

<label>Nama Supplier:</label><br>
<input type="text" name="nama" value="<?= htmlspecialchars($nama ?? "") ?>">
<span style="color: red;"><?= $error["nama"] ?? "" ?></span><br><br>

<label>Telepon:</label><br>
<input type="text" name="telp" value="<?= htmlspecialchars($telp ?? "") ?>">
<span style="color: red;"><?= $error["telp"] ?? "" ?></span><br><br>

<label>Alamat:</label><br>
<textarea name="alamat"><?= htmlspecialchars($alamat ?? "") ?></textarea>
<span style="color: red;"><?= $error["alamat"] ?? "" ?></span><br><br>

<button type="submit" name="submit">Simpan</button>
<a href="supplier.php">Batal</a>
