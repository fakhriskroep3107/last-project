<?php

require_once __DIR__ . '/../../db-config.php';

if (!empty($_POST['id'])) {
  $id = $_POST['id'];

  $connection->beginTransaction();

  //* Get Peminjaman By Id, buat di ambil relasi bukunya.
  $sql = "SELECT * FROM peminjaman WHERE id = ?";
  $statement = $connection->prepare($sql);
  $statement->execute([$id]);
  $peminjaman = $statement->fetch();

  //* Set status anggota menjadi 'Tidak Meminjam' lagi
  $sql = "UPDATE anggota SET status = 'Tidak Meminjam' WHERE id = ?";
  $updatedBook = $statement->execute([$peminjaman['anggota_id']]);

  //* Set status buku menjadi 'Tersedia' lagi
  $sql = "UPDATE books SET status = 'Tersedia' WHERE id = ?";
  $updatedBook = $statement->execute([$peminjaman['book_id']]);

  //* Delete Peminjaman
  $sql = "DELETE FROM peminjaman WHERE id = ?";
  $statement = $connection->prepare($sql);
  $statement->execute([$id]);
  $count = $statement->rowCount();

  $connection->commit();

  if ($count == 1) {
    $alert = <<<ALERT
    <script>
      alert('Delete Data Sucess!');
      window.location='../../peminjaman.php'
    </script>
  ALERT;

    echo $alert;
    exit();
  } else {
    $alert = <<<ALERT
    <script>
      alert('Delete Data Gagal!');
      window.location='../../peminjaman.php'
    </script>
  ALERT;

    echo $alert;
    exit();
  }
} else {
  $alert = <<<ALERT
    <script>
      alert('Data yang ingin di hapus tidak ditemukan!');
      window.location='../../peminjaman.php'
    </script>
  ALERT;

  echo $alert;
  exit();
}
