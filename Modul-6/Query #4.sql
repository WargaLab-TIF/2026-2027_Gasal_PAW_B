CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga INT NOT NULL,
    qty INT NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (barang_id) REFERENCES barang(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME,
    total INT NOT NULL,
    metode ENUM('TUNAI','TRANSFER','EDC'),
    transaksi_id INT NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE `user` (
    id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT
) ENGINE=InnoDB;