<?php if ($tabel === "pelanggan" && $aksi === "tambah") : ?>
<label for="id"> ID Pelanggan : </label>
<input type="text" name="id" value="<?= htmlspecialchars($id) ?>">
<span><?= $error["id"] ?? "" ?></span>

<br>
<?php else : ?>
<input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
<?php endif; ?>

<?php if ($tabel === "barang") : ?>
<label for="kode"> Kode Barang : </label>
<input type="text" name="kode" value="<?= htmlspecialchars($kode) ?>">
<span><?= $error["kode"] ?? "" ?></span>

<br>

<label for="nama"> Nama Barang : </label>
<input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
<span><?= $error["nama"] ?? "" ?></span>

<br>

<label for="harga"> Harga : </label>
<input type="text" name="harga" value="<?= htmlspecialchars($harga) ?>">
<span><?= $error["harga"] ?? "" ?></span>

<br>

<label for="stok"> Stok : </label>
<input type="text" name="stok" value="<?= htmlspecialchars($stok) ?>">
<span><?= $error["stok"] ?? "" ?></span>

<br>

<select name="supplier_id">
    <option value="">Nama supplier</option>
    <?php foreach ($suppliers as $supplier) : ?>
        <option value="<?= $supplier["id"] ?>" <?= $supplier_id == $supplier["id"] ? "selected" : "" ?>><?= htmlspecialchars($supplier["nama"]) ?></option>
    <?php endforeach; ?>
</select>
<span><?= $error["supplier"] ?? "" ?></span>

<br>
<?php elseif ($tabel === "supplier") : ?>
<label for="nama"> Nama Supplier : </label>
<input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
<span><?= $error["nama"] ?? "" ?></span>

<br>

<label for="telp"> Telp : </label>
<input type="text" name="telp" value="<?= htmlspecialchars($telp) ?>">
<span><?= $error["telp"] ?? "" ?></span>

<br>

<label for="alamat"> Alamat : </label>
<input type="text" name="alamat" value="<?= htmlspecialchars($alamat) ?>">
<span><?= $error["alamat"] ?? "" ?></span>

<br>
<?php elseif ($tabel === "pelanggan") : ?>
<label for="nama"> Nama Pelanggan : </label>
<input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
<span><?= $error["nama"] ?? "" ?></span>

<br>

<select name="jk">
    <option value="">Jenis kelamin</option>
    <option value="L" <?= $jk == "L" ? "selected" : "" ?>>L</option>
    <option value="P" <?= $jk == "P" ? "selected" : "" ?>>P</option>
</select>
<span><?= $error["jk"] ?? "" ?></span>

<br>

<label for="telp"> Telp : </label>
<input type="text" name="telp" value="<?= htmlspecialchars($telp) ?>">
<span><?= $error["telp"] ?? "" ?></span>

<br>

<label for="alamat"> Alamat : </label>
<input type="text" name="alamat" value="<?= htmlspecialchars($alamat) ?>">
<span><?= $error["alamat"] ?? "" ?></span>

<br>
<?php elseif ($tabel === "user") : ?>
<label for="username"> Username : </label>
<input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
<span><?= $error["username"] ?? "" ?></span>

<br>

<label for="password"> Password : </label>
<input type="password" name="password">
<span><?= $error["password"] ?? "" ?></span>
<?= $aksi === "edit" ? "(kosongkan jika tidak diganti)" : "" ?>

<br>

<label for="nama"> Nama : </label>
<input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
<span><?= $error["nama"] ?? "" ?></span>

<br>

<label for="alamat"> Alamat : </label>
<input type="text" name="alamat" value="<?= htmlspecialchars($alamat) ?>">
<span><?= $error["alamat"] ?? "" ?></span>

<br>

<label for="hp"> HP : </label>
<input type="text" name="hp" value="<?= htmlspecialchars($hp) ?>">
<span><?= $error["hp"] ?? "" ?></span>

<br>

<select name="level">
    <option value="">Level</option>
    <option value="1" <?= $level == 1 ? "selected" : "" ?>>1 - Owner</option>
    <option value="2" <?= $level == 2 ? "selected" : "" ?>>2 - Kasir</option>
</select>
<span><?= $error["level"] ?? "" ?></span>

<br>
<?php endif; ?>

<button type="submit" name="submit">Kirim</button>
<a href="index.php?halaman=<?= $tabel ?>">Batal</a>