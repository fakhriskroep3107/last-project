<?php
session_start();
require_once '../config/database.php';
require_once '../config/helpers.php';
require_once '../middleware/auth.php';

requireUser();

// Get available books
$availableBooks = fetchAll("SELECT * FROM books WHERE status = 'Tersedia' ORDER BY created_at DESC LIMIT 6");

// Get user's current loans (via nama matching - bisa diperbaiki dengan user_id)
$userName = $_SESSION['user_name'];
$myLoans = fetchAll("
    SELECT p.*, b.judul, b.pengarang, a.nama
    FROM peminjaman p
    INNER JOIN books b ON p.book_id = b.id
    INNER JOIN anggota a ON p.anggota_id = a.id
    WHERE a.nama = ?
    ORDER BY p.created_at DESC
", [$userName]);

include '../layouts/header-user.php';
?>

<!-- Header -->
<section>
    <div class="flex items-center mt-4">
        <h1 class="text-2xl pr-4 font-bold">
            Selamat Datang, <?= $_SESSION['user_name'] ?>!
        </h1>
    </div>
</section>

<!-- User Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white shadow-lg">
        <h3 class="text-lg opacity-80">Buku yang Dipinjam</h3>
        <p class="text-4xl font-bold mt-2"><?= count($myLoans) ?></p>
    </div>
    
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white shadow-lg">
        <h3 class="text-lg opacity-80">Buku Tersedia</h3>
        <p class="text-4xl font-bold mt-2"><?= count($availableBooks) ?></p>
    </div>
</div>

<!-- My Loans -->
<?php if (count($myLoans) > 0): ?>
<div class="bg-white rounded p-5 my-6 border shadow">
    <h2 class="text-xl font-bold mb-4">Buku yang Sedang Saya Pinjam</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php foreach ($myLoans as $loan): ?>
            <div class="border rounded-lg p-4 hover:shadow-md transition">
                <h3 class="font-semibold text-lg"><?= $loan['judul'] ?></h3>
                <p class="text-sm text-gray-600">Oleh: <?= $loan['pengarang'] ?></p>
                <div class="mt-3 flex justify-between text-sm">
                    <span class="text-gray-500">Pinjam: <?= formatTanggal($loan['tgl_pinjam']) ?></span>
                    <span class="text-red-500 font-medium">Kembali: <?= formatTanggal($loan['tgl_kembali']) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Available Books -->
<div class="bg-white rounded p-5 my-6 border shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Buku Tersedia</h2>
        <a href="books.php" class="text-blue-600 hover:underline text-sm">Lihat Semua →</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($availableBooks as $book): ?>
            <div class="border rounded-lg p-4 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="font-semibold"><?= $book['judul'] ?></h3>
                        <p class="text-sm text-gray-600 mt-1">Pengarang: <?= $book['pengarang'] ?></p>
                        <p class="text-sm text-gray-600">Penerbit: <?= $book['penerbit'] ?></p>
                        <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded">
                            <?= $book['status'] ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>