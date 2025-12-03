<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
  require_once __DIR__ . '/../db-config.php';

  $sql = "SELECT * FROM anggota ORDER BY id DESC";
  $statement = $connection->prepare($sql);
  $statement->execute();

  $anggota = $statement->fetchAll();
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
      font-size: 10pt;
    }

    table {
      border: 1px solid #ccc;
      border-collapse: collapse;
    }

    table th {
      background-color: #F7F7F7;
      color: #333;
      font-weight: bold;
      padding: 0.8rem;
      text-align: center;
    }

    table td {
      padding: 0.7rem;
    }

    table td:nth-child(1) {
      text-align: center;
    }

    table th,
    table td {
      border: 1px solid #ccc;
    }
  </style>
</head>

<body>
  <div id="tableWrapper">
    <table cellspacing="0" rules="all" border="1">
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Status</th>
        <th>Foto</th>
      </tr>
      <?php $i = 1; ?>
      <?php foreach ($anggota as $anggota) : ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $anggota['nama'] ?></td>
          <td><?= $anggota['gender'] ?></td>
          <td><?= $anggota['alamat'] ?></td>
          <td><?= $anggota['status'] ?></td>
          <td><?= $anggota['foto'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

</body>


</html>