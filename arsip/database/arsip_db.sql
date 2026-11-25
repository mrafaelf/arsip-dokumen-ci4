CREATE DATABASE IF NOT EXISTS arsip_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE arsip_db;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

CREATE TABLE archives (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  description TEXT NULL,
  file_name VARCHAR(255) NOT NULL,
  original_name VARCHAR(255) NOT NULL,
  file_type VARCHAR(100) NOT NULL,
  file_size INT UNSIGNED NOT NULL DEFAULT 0,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_archives_category FOREIGN KEY (category_id)
    REFERENCES categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Akun default: admin@arsip.test / admin123
INSERT INTO users (name,email,password,created_at) VALUES
('Administrator','admin@arsip.test','$2b$12$.P6H8Ki4kN3olZFMAuLa9uLHHSOq3OeCLFMCWRgSo0veaVmjSGbUq',NOW());

INSERT INTO categories (name,created_at) VALUES
('Surat Masuk',NOW()),('Surat Keluar',NOW()),('Laporan',NOW()),('Kontrak',NOW());
