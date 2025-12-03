<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
  if (!isset($_GET['id'])) {
    $alert = <<<ALERT
      <script>
        alert('Data yang ingin dicetak tidak ditemukan!');
        window.location='../book.php'
      </script>
    ALERT;

    echo $alert;
    exit();
  }

  $id = $_GET['id'];

  require_once __DIR__ . '/../db-config.php';

  $sql = "SELECT * FROM books WHERE id = ?";
  $statement = $connection->prepare($sql);
  $statement->execute([$id]);

  if ($book = $statement->fetch()) {
    $id = $book['id'];
    $judul = $book['judul'];
    $kategori = $book['kategori'];
    $pengarang = $book['pengarang'];
    $penerbit = $book['penerbit'];
    $status = $book['status'];
  } else {
    $alert = <<<ALERT
      <script>
        alert('Data tersebut tidak ditemukan!');
        window.location='../book.php'
      </script>
    ALERT;

    echo $alert;
    exit();
  }
} else {
  $alert = <<<ALERT
    <script>
      alert('Login Terlebih Dahulu, Untuk Mengakses Halaman Web!');
      window.location='../auth/login.php';
    </script>
  ALERT;

  echo $alert;
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan</title>
  <style id="table_style" type="text/css">
    body {
      font-family: Arial;
      font-size: 1rem;
    }

    /* table {
      border: 1px solid #ccc;
      border-collapse: collapse;
    } */

    table th {
      /* background-color: #F7F7F7; */
      color: #333;
      font-weight: bold;
      padding: 0.3rem;
      text-align: left;
    }

    table td {
      padding: 0.3rem;
    }

    /* table td:nth-child(1) {
      text-align: center;
    } */

    /* table th,
    table td {
      border: 1px solid #ccc;
    } */
  </style>
</head>

<body>
  <div id="tableWrapper">
    <h1>Data Buku : <?= $judul ?></h1>

    <table>
      <tr>
        <th>ID Buku</th>
        <td>:</td>
        <td><?= $id ?></td>
      </tr>
      <tr>
      <tr>
        <th>Judul Buku</th>
        <td>:</td>
        <td><?= $judul ?></td>
      </tr>
      <tr>
        <th>Kategori</th>
        <td>:</td>
        <td><?= $kategori ?></td>
      </tr>
      <tr>
        <th>Pengarang</th>
        <td>:</td>
        <td><?= $pengarang ?></td>
      </tr>
      <tr>
        <th>Penerbit</th>
        <td>:</td>
        <td><?= $penerbit ?></td>
      </tr>
      <tr>
        <th>Status</th>
        <td>:</td>
        <td><?= $status ?></td>
      </tr>
    </table>
  </div>

</body>


</html>