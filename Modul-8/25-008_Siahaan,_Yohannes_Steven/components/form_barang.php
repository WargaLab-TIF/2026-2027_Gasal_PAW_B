<input type="hidden" name="id" value="<?= htmlspecialchars($id ?? "") ?>">

<label>Kode Barang:</label><br>
<input type="text" name="kode_barang" value="<?= htmlspecialchars($kode_barang ?? "") ?>">
<span style="color: red;"><?= $error["kode_barang"] ?? "" ?></span><br><br>

<label>Nama Barang:</label><br>
<input type="text" name="nama_barang" value="<?= htmlspecialchars($nama_barang ?? "") ?>">
<span style="color: red;"><?= $error["nama_barang"] ?? "" ?></span><br><br>

<label>Harga:</label><br>
<input type="text" name="harga" value="<?= htmlspecialchars($harga ?? "") ?>">
<span style="color: red;"><?= $error["harga"] ?? "" ?></span><br><br>

<label>Stok:</label><br>
<input type="text" name="stok" value="<?= htmlspecialchars($stok ?? "") ?>">
<span style="color: red;"><?= $error["stok"] ?? "" ?></span><br><br>

<label>Supplier:</label><br>
<select name="supplier_id">
    <option value="">-- Pilih Supplier --</option>
    <?php foreach ($suppliers as $sup): ?>
        <option value="<?= $sup["id"] ?>" <?= (($supplier_id ?? "") == $sup["id"]) ? "selected" : "" ?>>
            <?= htmlspecialchars($sup["nama"]) ?>
        </option>
    <?php endforeach; ?>
</select>
<span style="color: red;"><?= $error["supplier_id"] ?? "" ?></span><br><br>

<button type="submit" name="submit">Simpan</button>
<a href="barang.php">Batal</a>
