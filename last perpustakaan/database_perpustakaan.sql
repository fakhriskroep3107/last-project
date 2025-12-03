-- =====================================================
-- DATABASE PERPUSTAKAAN - FRESH START
-- =====================================================

-- Drop database jika sudah ada
DROP DATABASE IF EXISTS perpustakaan;

-- Buat database baru
CREATE DATABASE perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE perpustakaan;

-- =====================================================
-- TABEL USERS (untuk login & role)
-- =====================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin dan user
INSERT INTO users (name, email, password, role) VALUES
('Administrator', 'admin@perpus.com', 'admin123', 'admin'),
('Anggota Test', 'user@perpus.com', 'user123', 'user');

-- =====================================================
-- TABEL ANGGOTA (data lengkap anggota perpustakaan)
-- =====================================================
CREATE TABLE anggota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    gender ENUM('Pria', 'Wanita') NOT NULL,
    alamat TEXT NOT NULL,
    status ENUM('Tidak Meminjam', 'Sedang Meminjam') NOT NULL DEFAULT 'Tidak Meminjam',
    foto VARCHAR(255) NOT NULL DEFAULT 'default-avatar.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample anggota
INSERT INTO anggota (nama, gender, alamat, status, foto) VALUES
('Muhammad Alif', 'Pria', 'Jl Kenanga Baru No. 10', 'Tidak Meminjam', 'AVA-62690ac06d9464.21820944.jpg'),
('Siti Nurhaliza', 'Wanita', 'Jalan Margonda Raya No. 5', 'Tidak Meminjam', 'AVA-62690ab6bf87c9.76482767.jpg'),
('Budi Santoso', 'Pria', 'Jl Sudirman No. 123', 'Tidak Meminjam', 'AVA-62690a781c3a34.37947109.jpg');

-- =====================================================
-- TABEL BUKU
-- =====================================================
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    pengarang VARCHAR(255) NOT NULL,
    penerbit VARCHAR(255) NOT NULL,
    status ENUM('Tersedia', 'Dipinjam') NOT NULL DEFAULT 'Tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample books
INSERT INTO books (judul, kategori, pengarang, penerbit, status) VALUES
('Harry Potter and the Philosopher\'s Stone', 'Fiksi', 'J.K Rowling', 'Media Cipta', 'Tersedia'),
('Laskar Pelangi', 'Novel', 'Andrea Hirata', 'Media Baca', 'Tersedia'),
('Dilan 1990', 'Romansa', 'Pidi Baiq', 'Media Baca', 'Tersedia'),
('Bumi Manusia', 'Sejarah', 'Pramoedya Ananta Toer', 'Media Kita', 'Tersedia'),
('Koala Kumal', 'Komedi', 'Raditya Dika', 'Media Baca', 'Tersedia'),
('Milea: Suara dari Dilan', 'Romansa', 'Pidi Baiq', 'Graha', 'Tersedia');

-- =====================================================
-- TABEL PEMINJAMAN
-- =====================================================
CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anggota_id INT NOT NULL,
    book_id INT NOT NULL,
    tgl_pinjam DATE NOT NULL,
    tgl_kembali DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (anggota_id) REFERENCES anggota(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL PENGEMBALIAN
-- =====================================================
CREATE TABLE pengembalian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anggota_id INT NOT NULL,
    book_id INT NOT NULL,
    tgl_pinjam DATE NOT NULL,
    tgl_kembali DATE NOT NULL,
    tgl_dikembalikan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (anggota_id) REFERENCES anggota(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- INDEXES untuk performa
-- =====================================================
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_anggota_status ON anggota(status);
CREATE INDEX idx_books_status ON books(status);
CREATE INDEX idx_peminjaman_anggota ON peminjaman(anggota_id);
CREATE INDEX idx_peminjaman_book ON peminjaman(book_id);
CREATE INDEX idx_pengembalian_anggota ON pengembalian(anggota_id);

-- =====================================================
-- VIEWS untuk kemudahan query
-- =====================================================

-- View untuk data peminjaman lengkap
CREATE VIEW v_peminjaman_lengkap AS
SELECT 
    p.id,
    p.anggota_id,
    a.nama as nama_anggota,
    p.book_id,
    b.judul as judul_buku,
    p.tgl_pinjam,
    p.tgl_kembali,
    DATEDIFF(p.tgl_kembali, CURDATE()) as hari_tersisa,
    p.created_at
FROM peminjaman p
INNER JOIN anggota a ON p.anggota_id = a.id
INNER JOIN books b ON p.book_id = b.id
ORDER BY p.created_at DESC;

-- View untuk data pengembalian lengkap
CREATE VIEW v_pengembalian_lengkap AS
SELECT 
    pg.id,
    pg.anggota_id,
    a.nama as nama_anggota,
    pg.book_id,
    b.judul as judul_buku,
    pg.tgl_pinjam,
    pg.tgl_kembali,
    pg.tgl_dikembalikan,
    DATEDIFF(pg.tgl_dikembalikan, pg.tgl_kembali) as keterlambatan_hari
FROM pengembalian pg
INNER JOIN anggota a ON pg.anggota_id = a.id
INNER JOIN books b ON pg.book_id = b.id
ORDER BY pg.tgl_dikembalikan DESC;

-- =====================================================
-- STORED PROCEDURES
-- =====================================================

DELIMITER //

-- Procedure untuk proses peminjaman
CREATE PROCEDURE sp_pinjam_buku(
    IN p_anggota_id INT,
    IN p_book_id INT,
    IN p_tgl_pinjam DATE,
    IN p_tgl_kembali DATE
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Gagal memproses peminjaman';
    END;
    
    START TRANSACTION;
    
    -- Insert peminjaman
    INSERT INTO peminjaman (anggota_id, book_id, tgl_pinjam, tgl_kembali)
    VALUES (p_anggota_id, p_book_id, p_tgl_pinjam, p_tgl_kembali);
    
    -- Update status buku
    UPDATE books SET status = 'Dipinjam' WHERE id = p_book_id;
    
    -- Update status anggota
    UPDATE anggota SET status = 'Sedang Meminjam' WHERE id = p_anggota_id;
    
    COMMIT;
END//

-- Procedure untuk proses pengembalian
CREATE PROCEDURE sp_kembalikan_buku(
    IN p_peminjaman_id INT
)
BEGIN
    DECLARE v_anggota_id INT;
    DECLARE v_book_id INT;
    DECLARE v_tgl_pinjam DATE;
    DECLARE v_tgl_kembali DATE;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Gagal memproses pengembalian';
    END;
    
    START TRANSACTION;
    
    -- Ambil data peminjaman
    SELECT anggota_id, book_id, tgl_pinjam, tgl_kembali
    INTO v_anggota_id, v_book_id, v_tgl_pinjam, v_tgl_kembali
    FROM peminjaman
    WHERE id = p_peminjaman_id;
    
    -- Insert ke pengembalian
    INSERT INTO pengembalian (anggota_id, book_id, tgl_pinjam, tgl_kembali)
    VALUES (v_anggota_id, v_book_id, v_tgl_pinjam, v_tgl_kembali);
    
    -- Hapus dari peminjaman
    DELETE FROM peminjaman WHERE id = p_peminjaman_id;
    
    -- Update status buku
    UPDATE books SET status = 'Tersedia' WHERE id = v_book_id;
    
    -- Update status anggota (cek dulu apakah masih ada peminjaman lain)
    UPDATE anggota 
    SET status = CASE 
        WHEN (SELECT COUNT(*) FROM peminjaman WHERE anggota_id = v_anggota_id) = 0 
        THEN 'Tidak Meminjam' 
        ELSE 'Sedang Meminjam' 
    END
    WHERE id = v_anggota_id;
    
    COMMIT;
END//

DELIMITER ;

-- =====================================================
-- SAMPLE TRIGGER untuk logging
-- =====================================================
CREATE TABLE activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255),
    table_name VARCHAR(100),
    record_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- SELESAI
-- =====================================================
SELECT 'Database perpustakaan berhasil dibuat!' as status;
SELECT COUNT(*) as total_users FROM users;
SELECT COUNT(*) as total_anggota FROM anggota;
SELECT COUNT(*) as total_books FROM books;