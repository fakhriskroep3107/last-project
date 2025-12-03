<?php

require_once __DIR__ . '/../../db-config.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $sql = "DELETE FROM books WHERE id = ?";
  $statement = $connection->prepare($sql);
  $statement->execute([$id]);
  $count = $statement->rowCount();

  if ($count == 1) {
    $alert = <<<ALERT
    <script>
      alert('Delete Data Sucess!');
      window.location='../../book.php'
    </script>
  ALERT;

    echo $alert;
    exit();
  } else {
    $alert = <<<ALERT
    <script>
      alert('Delete Data Gagal!');
      window.location='../../book.php'
    </script>
  ALERT;

    echo $alert;
    exit();
  }
} else {
  $alert = <<<ALERT
    <script>
      alert('Data yang ingin di hapus tidak ditemukan!');
      window.location='../../book.php'
    </script>
  ALERT;

  echo $alert;
  exit();
}
