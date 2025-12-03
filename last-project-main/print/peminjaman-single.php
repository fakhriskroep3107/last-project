<?php
session_start();

if (!empty($_SESSION['id']) && !empty($_SESSION['email'])) {
  if (empty($_GET['id'])) {
    $alert = <<<ALERT
      <script>
        alert('Data yang ingin dicetak tidak ditemukan!');
        window.location='../peminjaman.php'
      </script>
    ALERT;

    echo $alert;
    exit();
  }

  $id = $_GET['id'];

  require_once __DIR__ . '/../db-config.php';

  $sql = <<<SQL
    SELECT peminjaman.*, 
    anggota.nama as anggota, 
    books.judul as buku 
    FROM peminjaman 
    INNER JOIN anggota ON peminjaman.anggota_id = anggota.id
    INNER JOIN books ON peminjaman.book_id = books.id
    WHERE peminjaman.id = ?
  SQL;
  $statement = $connection->prepare($sql);
  $statement->execute([$id]);

  if ($peminjaman = $statement->fetch()) {
    $id = $peminjaman['id'];
    $anggotaId = $peminjaman['anggota_id'];
    $anggota = $peminjaman['anggota'];
    $bookId = $peminjaman['book_id'];
    $buku = $peminjaman['buku'];
    $tglPinjam = $peminjaman['tgl_pinjam'];
    $tglKembali = $peminjaman['tgl_kembali'];
  } else {
    $alert = <<<ALERT
      <script>
        alert('Data tersebut tidak ditemukan!');
        window.location='../peminjaman.php'
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
    <h1>Data Peminjaman, Anggota (id) : <?= $anggotaId ?></h1>

    <table>
      <tr>
        <th>ID Peminjaman</th>
        <td>:</td>
        <td><?= $id ?></td>
      </tr>
      <tr>
      <tr>
        <th>ID Anggota</th>
        <td>:</td>
        <td><?= $anggotaId ?></td>
      </tr>
      <tr>
        <th>Nama Anggota</th>
        <td>:</td>
        <td><?= $anggota ?></td>
      </tr>
      <tr>
        <th>ID Buku</th>
        <td>:</td>
        <td><?= $bookId ?></td>
      </tr>
      <tr>
        <th>Judul Buku</th>
        <td>:</td>
        <td><?= $buku ?></td>
      </tr>
      <tr>
        <th>Tanggal Pinjam</th>
        <td>:</td>
        <td><?= $tglPinjam ?></td>
      </tr>
      <tr>
        <th>Tanggal Kembali</th>
        <td>:</td>
        <td><?= $tglKembali ?></td>
      </tr>
    </table>
  </div>

</body>


</html>