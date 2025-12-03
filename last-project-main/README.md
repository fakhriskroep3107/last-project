# Imam Alfarizi Syahputra - JWD 3

## _Aplikasi Perpustakaan (Tugas Akhir Digitalent)_

## 1. Instalasi

1. Import file "tugas_akhir_database.sql" ke Database di "phpmyadmin".
2. Lalu insert data user di table "users" (jika belum ada). Untuk Autentikasi di Halaman Login (login.php).
3. Kemudian masuk ke halaman "login.php".
4. Isi Email dan Password sesuai dengan data yang ada di table "users".
5. Jika berhasil, akan di redirect ke halaman List Dashboard (index.php).

## 2. FITUR APLIKASI

1. Autentikasi (Login, Register)
2. Halaman Buku
   - CRUD, CETAK BUKU
3. Halaman Anggota
   - CRUD, Search, Pagination, CETAK Anggota
4. Halaman Peminjaman

   - CRUD, Search, Pagination, CETAK Peminjaman
   - Ketika Menambah Buku
     => Status Buku menjadi "Dipinjam"
     => Status Anggota menjadi "Sedang Meminjam"
   - Ketika Menghapus Buku
     => Status Buku menjadi "Tersedia"
     => Status Anggota menjadi "Tidak Meminjam"
   - Ketika Buku dan Anggota sedang dalam Peminjaman => Tidak dapat melakukan peminjaman kembali (Menunggu Pengembalian)
   - Tombol Kembalikan Buku
     => Status Buku menjadi "Tersedia"
     => Status Anggota menjadi "Tidak Meminjam"

5. Halaman Pengembalian
   - Search, Pagination, CETAK Pengembalian
   - Ketika Buku dan Anggota sedang dalam Peminjaman => Tidak dapat melakukan peminjaman kembali (Menunggu Pengembalian)

## Github Link

dibawah ini adalah link "Github" dari project ini

| Github | https://github.com/ImamAlfariziSyahputra/digitalent-last-project |
| ------ | ---------------------------------------------------------------- |
