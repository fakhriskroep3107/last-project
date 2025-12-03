<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
  if (!isset($_GET['id'])) {
    $alert = <<<ALERT
      <script>
        alert('Data yang ingin dicetak tidak ditemukan!');
        window.location='../anggota.php'
      </script>
    ALERT;

    echo $alert;
    exit();
  }

  $id = $_GET['id'];

  require_once __DIR__ . '/../db-config.php';

  $sql = "SELECT * FROM anggota WHERE id = ?";
  $statement = $connection->prepare($sql);
  $statement->execute([$id]);

  if ($anggota = $statement->fetch()) {
    $id = $anggota['id'];
    $nama = $anggota['nama'];
    $gender = $anggota['gender'];
    $alamat = $anggota['alamat'];
    $status = $anggota['status'];
    $foto = $anggota['foto'];
  } else {
    $alert = <<<ALERT
      <script>
        alert('Data tersebut tidak ditemukan!');
        window.location='../anggota.php'
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
    <h1>Data Anggota : <?= $nama ?></h1>

    <table>
      <tr>
        <th>ID Anggota</th>
        <td>:</td>
        <td><?= $id ?></td>
      </tr>
      <tr>
      <tr>
        <th>Nama</th>
        <td>:</td>
        <td><?= $nama ?></td>
      </tr>
      <tr>
        <th>Jenis Kelamin</th>
        <td>:</td>
        <td><?= $gender ?></td>
      </tr>
      <tr>
        <th>Alamat</th>
        <td>:</td>
        <td><?= $alamat ?></td>
      </tr>
      <tr>
        <th>Status</th>
        <td>:</td>
        <td><?= $status ?></td>
      </tr>
      <tr>
        <th>Foto</th>
        <td>:</td>
        <td><?= $foto ?></td>
      </tr>
    </table>
  </div>

</body>


</html>