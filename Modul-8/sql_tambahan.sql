USE db_penjualan;

-- Password hash membutuhkan kolom yang cukup panjang.
ALTER TABLE `user` MODIFY `password` VARCHAR(255) NOT NULL;

-- Jika akun lama dari database sebelumnya masih menggunakan password teks biasa,
-- login pertama akan memverifikasi lalu otomatis mengubah password menjadi hash.

-- Level akun: 1 = Owner, 2 = Kasir.
-- Pastikan minimal ada satu user level 1 dan satu user level 2 pada tabel user.


-- Akun awal untuk mencoba aplikasi (akan dibuat jika username belum ada).
INSERT INTO `user` (username, password, nama, alamat, hp, level)
SELECT 'owner', '$2y$12$9AJgVN8OE0RUt7pLP4qyjOA9hFfUbz5z/5/4TZVlDmQmWhVvMpKNS', 'Owner', 'Madura', '080000000001', 1
WHERE NOT EXISTS (SELECT 1 FROM `user` WHERE username='owner');

INSERT INTO `user` (username, password, nama, alamat, hp, level)
SELECT 'kasir', '$2y$12$X.InsJprF.nJidc20wyrUeF21Vf9qObmf8uQP8wTexUO7TzhfhP7C', 'Kasir', 'Madura', '080000000002', 2
WHERE NOT EXISTS (SELECT 1 FROM `user` WHERE username='kasir');
