<input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
<label for="judul"> Judul Buku : </label>
<input type="text" name="judul" value="<?= htmlspecialchars($judul ?? "") ?>">
<span style="color: red;"><?= $error["judul"] ?? "" ?></span>

<br>

<label for="penulis"> Penulis : </label>
<input type="text" name="penulis" value="<?= htmlspecialchars($penulis ?? "") ?>">
<span style="color: red;"><?= $error["penulis"] ?? "" ?></span>

<br>

<label for="tahun"> Tahun Terbit : </label>
<input type="text" name="tahun" value="<?= htmlspecialchars($tahun ?? "") ?>">
<span style="color: red;"><?= $error["tahun"] ?? "" ?></span>

<br>

<label for="stok"> Stok : </label>
<input type="text" name="stok" value="<?= htmlspecialchars($stok ?? "") ?>">
<span style="color: red;"><?= $error["stok"] ?? "" ?></span>

<br>

<select name="nama_kategori">
 <option value="">Nama kategori</option>
 <?php foreach($kategoris as $kategori) :?>
 <option value="<?= $kategori["id_kategori_buku"] ?>" <?= ($nama_kategori ?? "") == $kategori["id_kategori_buku"] ? "selected" : "" ?>><?= $kategori["nama_kategori"] ?></option>
<?php endforeach ;?>
</select>
<span style="color: red;"><?= $error["kategori"] ?? "" ?></span>

<br>

<button type="submit" name="submit">Kirim</button>
<a href="barang.php">Batal</a>