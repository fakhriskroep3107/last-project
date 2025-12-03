<?php

require __DIR__ . '/../../db-config.php';
require_once __DIR__ . '/../requiredFunction.php';

$id = $_POST['id'];

if (empty($_POST['anggota_id'])) {
  required(name: 'Anggota', file: 'peminjaman-edit', id: $id);
}
if (empty($_POST['book_id'])) {
  required(name: 'Buku', file: 'peminjaman-edit', id: $id);
}
if (empty($_POST['tgl_pinjam'])) {
  required(name: 'Tanggal Pinjam', file: 'peminjaman-edit', id: $id);
}
if (empty($_POST['tgl_kembali'])) {
  required(name: 'Tanggal Kembali', file: 'peminjaman-edit', id: $id);
}

$anggotaId = $_POST['anggota_id'];
$bookId = $_POST['book_id'];
$tglPinjam = $_POST['tgl_pinjam'];
$tglKembali = $_POST['tgl_kembali'];

$sql = "UPDATE peminjaman SET anggota_id = ?, book_id = ?, tgl_pinjam = ?, tgl_kembali = ? WHERE id = ?";
$statement = $connection->prepare($sql);
$updatedData = $statement->execute([$anggotaId, $bookId, $tglPinjam, $tglKembali, $id]);

// //* Update Status Anggota jadi "Sedang Meminjam"
// $sql = "UPDATE anggota SET status = 'Sedang Meminjam' WHERE id = ?";
// $statement = $connection->prepare($sql);
// $updatedBook = $statement->execute([$anggota_id]);

// //* Update Status Buku jadi "Dipinjam"
// $sql = "UPDATE books SET status = 'Dipinjam' WHERE id = ?";
// $statement = $connection->prepare($sql);
// $updatedBook = $statement->execute([$book_id]);

if ($updatedData == true) {
  $alert = <<<ALERT
      <script>
        alert('Update Data Sucess!');
        window.location='../../peminjaman.php'
      </script>
    ALERT;

  echo $alert;
  exit();
} else {
  $alert = <<<ALERT
      <script>
        alert('Edit Data Gagal!');
        window.location='../../peminjaman-edit.php?id=$id'
      </script>
    ALERT;

  echo $alert;
  exit();
}
