<?php

require __DIR__ . '/../../db-config.php';
require_once __DIR__ . '/../requiredFunction.php';

$id = $_POST['id'];

if (empty($_POST['judul'])) {
  required(name: 'Judul', file: 'book-edit', id: $id);
}
if (empty($_POST['kategori'])) {
  required(name: 'Kategori', file: 'book-edit', id: $id);
}
if (empty($_POST['pengarang'])) {
  required(name: 'Pengarang', file: 'book-edit', id: $id);
}
if (empty($_POST['penerbit'])) {
  required(name: 'Penerbit', file: 'book-edit', id: $id);
}
if (empty($_POST['status'])) {
  required(name: 'Status', file: 'book-edit', id: $id);
}

$judul = $_POST['judul'];
$kategori = $_POST['kategori'];
$pengarang = $_POST['pengarang'];
$penerbit = $_POST['penerbit'];
$status = $_POST['status'];

$sql = "UPDATE books SET judul = ?, kategori = ?, pengarang = ?, penerbit = ?, status = ? WHERE id = ?";

$statement = $connection->prepare($sql);
$updatedData = $statement->execute([$judul, $kategori, $pengarang, $penerbit, $status, $id]);

if ($updatedData == true) {
  $alert = <<<ALERT
      <script>
        alert('Update Data Sucess!');
        window.location='../../book.php'
      </script>
    ALERT;

  echo $alert;
  exit();
} else {
  $alert = <<<ALERT
      <script>
        alert('Edit Data Gagal!');
        window.location='../../book-edit.php?id=$id'
      </script>
    ALERT;

  echo $alert;
  exit();
}
