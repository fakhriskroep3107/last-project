<?php
session_start();

require_once __DIR__ . '/../../db-config.php';

$id_peminjaman = $_POST['id'];
$anggota_id = $_POST['anggota_id'];
$book_id = $_POST['book_id'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];

// var_dump(
//   $id_peminjaman,
//   $anggota_id,
//   $book_id,
//   $tgl_pinjam,
//   $tgl_kembali,
// );
// exit();

$connection->beginTransaction();

//* Move data from "Table Peminjaman" to "Table Pengambalian"
$sql = "INSERT INTO pengembalian(anggota_id,book_id,tgl_pinjam,tgl_kembali) VALUES( ? , ? , ? , ? )";
$statement = $connection->prepare($sql);
$statement->execute([$anggota_id, $book_id, $tgl_pinjam, $tgl_kembali]);
$count = $statement->rowCount();

//* Delete data from "Table Peminjaman"
$sql = "DELETE FROM peminjaman WHERE id = ?";
$statement = $connection->prepare($sql);
$statement->execute([$id_peminjaman]);
$count = $statement->rowCount();

//* Update Status Anggota jadi "Tidak Meminjam"
$sql = "UPDATE anggota SET status = 'Tidak Meminjam' WHERE id = ?";
$statement = $connection->prepare($sql);
$updatedAnggota = $statement->execute([$anggota_id]);

//* Update Status Buku jadi "Tersedia"
$sql = "UPDATE books SET status = 'Tersedia' WHERE id = ?";
$statement = $connection->prepare($sql);
$updatedBook = $statement->execute([$book_id]);

$connection->commit();

if ($count == 1) {
  $alert = <<<ALERT
    <script>
      alert('Pengembalian Buku Sucess, Silahkan Cek di Halaman Pengembalian!');
      window.location='../../peminjaman.php'
    </script>
  ALERT;

  echo $alert;
  exit();
} else {
  $alert = <<<ALERT
    <script>
      alert('Pengembalian Buku Gagal!');
      window.location='../../peminjaman-add.php'
    </script>
  ALERT;

  echo $alert;
  exit();
}
