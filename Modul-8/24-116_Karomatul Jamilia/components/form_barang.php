<input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
<label>Kode Barang : </label>
<input type="text" name="kode" maxlength="10" value="<?= htmlspecialchars($kode) ?>">
<span style="color: red;"><?= $error["kode"] ?? "" ?></span>
<br><br>
<label>Nama Barang : </label>
<input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
<span style="color: red;"><?= $error["nama"] ?? "" ?></span>
<br><br>
<label>Harga : </label>
<input type="text" name="harga" value="<?= htmlspecialchars($harga) ?>">
<span style="color: red;"><?= $error["harga"] ?? "" ?></span>
<br><br>
<label>Stok : </label>
<input type="text" name="stok" value="<?= htmlspecialchars($stok) ?>">
<span style="color: red;"><?= $error["stok"] ?? "" ?></span>
<br><br>
<label>Supplier : </label>
<select name="supplier">
    <option value="">-- Pilih Supplier --</option>
    <?php foreach ($suppliers as $s) : ?>
        <option value="<?= $s["id_supplier"] ?>" <?= $supplier_id == $s["id_supplier"] ? "selected" : "" ?>><?= htmlspecialchars($s["nama"]) ?></option>
    <?php endforeach; ?>
</select>
<span style="color: red;"><?= $error["supplier"] ?? "" ?></span>
<br><br>
<button type="submit" name="submit">Kirim</button>
<a href="index.php">Batal</a>
