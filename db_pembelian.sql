CREATE USER "admin"@"localhost" IDENTIFIED BY "password";
CREATE DATABASE db_penjualan;
GRANT ALL PRIVILEGES ON db_penjualan.* TO "admin"@"localhost";
FLUSH PRIVILEGES;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pembelian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    layanan_produk VARCHAR(100) NOT NULL,
    jenis ENUM('Sparepart', 'Service') NOT NULL,
    jumlah INT NOT NULL,
    harga INT NOT NULL,
    total INT NOT NULL,
    toko VARCHAR(100),
    deskripsi TEXT,
    foto VARCHAR(255)
);