<?php
session_start();
require_once '../config/database.php';
require_once '../config/helpers.php';
require_once '../middleware/auth.php';

requireAdmin();

// Get statistics
$totalBooks = fetchOne("SELECT COUNT(*) as total FROM books")['total'];
$totalAnggota = fetchOne("SELECT COUNT(*) as total FROM anggota")['total'];
$totalPeminjaman = fetchOne("SELECT COUNT(*) as total FROM peminjaman")['total'];
$totalPengembalian = fetchOne("SELECT COUNT(*) as total FROM pengembalian")['total'];

// Get recent peminjaman
$recentPeminjaman = fetchAll("
    SELECT p.*, a.nama as anggota, b.judul as buku 
    FROM peminjaman p
    INNER JOIN anggota a ON p.anggota_id = a.id
    INNER JOIN books b ON p.book_id = b.id
    ORDER BY p.created_at DESC 
    LIMIT 5
");

include '../layouts/header.php';
?>

<!-- Header -->
<section>
    <div class="flex items-center mt-4">
        <h1 class="text-2xl pr-4 font-bold">Dashboard Admin</h1>
    </div>
</section>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 my-6">
    <!-- Total Buku -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80">Total Buku</p>
                <h3 class="text-3xl font-bold mt-2"><?= $totalBooks ?></h3>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <img src="../icons/book-b.svg" class="w-8 h-8 invert" alt="Book">
            </div>
        </div>
    </div>

    <!-- Total Anggota -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80">Total Anggota</p>
                <h3 class="text-3xl font-bold mt-2"><?= $totalAnggota ?></h3>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <img src="../icons/anggota-b.svg" class="w-8 h-8 invert" alt="Anggota">
            </div>
        </div>
    </div>

    <!-- Sedang Dipinjam -->
    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80">Sedang Dipinjam</p>
                <h3 class="text-3xl font-bold mt-2"><?= $totalPeminjaman ?></h3>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <img src="../icons/peminjaman-b.svg" class="w-8 h-8 invert" alt="Peminjaman">
            </div>
        </div>
    </div>

    <!-- Total Pengembalian -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80">Total Pengembalian</p>
                <h3 class="text-3xl font-bold mt-2"><?= $totalPengembalian ?></h3>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <img src="../icons/pengembalian-b.svg" class="w-8 h-8 invert" alt="Pengembalian">
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded p-5 my-6 border shadow">
    <h2 class="text-xl font-bold mb-4">Peminjaman Terbaru</h2>
    
    <?php if (count($recentPeminjaman) > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-3">Anggota</th>
                        <th class="px-4 py-3">Buku</th>
                        <th class="px-4 py-3">Tanggal Pinjam</th>
                        <th class="px-4 py-3">Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentPeminjaman as $item): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3"><?= $item['anggota'] ?></td>
                            <td class="px-4 py-3"><?= $item['buku'] ?></td>
                            <td class="px-4 py-3"><?= formatTanggal($item['tgl_pinjam']) ?></td>
                            <td class="px-4 py-3"><?= formatTanggal($item['tgl_kembali']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-right">
            <a href="peminjaman.php" class="text-blue-600 hover:underline text-sm">Lihat Semua →</a>
        </div>
    <?php else: ?>
        <p class="text-gray-500 text-center py-8">Belum ada data peminjaman</p>
    <?php endif; ?>
</div>

<?php include '../layouts/footer.php'; ?>