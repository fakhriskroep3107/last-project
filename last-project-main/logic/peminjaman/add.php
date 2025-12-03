<?php
session_start();

require_once __DIR__ . '/../../db-config.php';
require_once __DIR__ . '/../requiredFunction.php';

if (empty($_POST['anggota_id'])) {
  required(name: 'Anggota', file: 'peminjaman-add');
}
if (empty($_POST['book_id'])) {
  required(name: 'Buku', file: 'peminjaman-add');
}
if (empty($_POST['tgl_pinjam'])) {
  required(name: 'Tanggal Pinjam', file: 'peminjaman-add');
}
if (empty($_POST['tgl_kembali'])) {
  required(name: 'Tanggal Kembali', file: 'peminjaman-add');
}

$anggota_id = $_POST['anggota_id'];
$book_id = $_POST['book_id'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];

// var_dump(
//   $anggota_id,
//   $book_id,
//   $tgl_pinjam,
//   $tgl_kembali,
// );
// exit();

$connection->beginTransaction();

//* Add Peminjaman
$sql = "INSERT INTO peminjaman(anggota_id,book_id,tgl_pinjam,tgl_kembali) VALUES( ? , ? , ? , ? )";
$statement = $connection->prepare($sql);
$statement->execute([$anggota_id, $book_id, $tgl_pinjam, $tgl_kembali]);
$count = $statement->rowCount();

//* Update Status Anggota jadi "Sedang Meminjam"
$sql = "UPDATE anggota SET status = 'Sedang Meminjam' WHERE id = ?";
$statement = $connection->prepare($sql);
$updatedBook = $statement->execute([$anggota_id]);
//* Update Status Buku jadi "Dipinjam"
$sql = "UPDATE books SET status = 'Dipinjam' WHERE id = ?";
$statement = $connection->prepare($sql);
$updatedBook = $statement->execute([$book_id]);

$connection->commit();

// var_dump($count);
// exit();

if ($count == 1) {
  $alert = <<<ALERT
    <script>
      alert('Tambah Data Sucess!');
      window.location='../../peminjaman.php'
    </script>
  ALERT;

  echo $alert;
  exit();
} else {
  $alert = <<<ALERT
    <script>
      alert('Tambah Data Gagal!');
      window.location='../../peminjaman-add.php'
    </script>
  ALERT;

  echo $alert;
  exit();
}
