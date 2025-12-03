<?php
session_start();

require_once __DIR__ . '/../../db-config.php';
require_once __DIR__ . '/../requiredFunction.php';

if (empty($_POST['nama'])) {
  required(name: 'Nama', file: 'anggota-add');
}
if (empty($_POST['gender'])) {
  required(name: 'Gender', file: 'anggota-add');
}
if (empty($_POST['alamat'])) {
  required(name: 'Alamat', file: 'anggota-add');
}
if (empty($_POST['status'])) {
  required(name: 'Status', file: 'anggota-add');
}
if (empty($_FILES['foto']['name'])) {
  required(name: 'Foto', file: 'anggota-add');
}

$nama = $_POST['nama'];
$gender = $_POST['gender'];
$alamat = $_POST['alamat'];
$status = $_POST['status'];
$foto = $_FILES['foto'];

// var_dump(
//   $nama,
//   $gender,
//   $alamat,
//   $status,
//   $foto,
// );
// exit();

$imgName = $_FILES['foto']['name'];
$imgSize = $_FILES['foto']['size'];
$tmpName = $_FILES['foto']['tmp_name'];
$error = $_FILES['foto']['error'];

if ($error === 0) {
  if ($imgSize > 125000) {
    $alert = <<<ALERT
      <script>
        alert('Tambah Data Gagal!');
        window.location='../../anggota-add.php?error=Ukuran Gambar Terlalu Besar!'
      </script>
    ALERT;

    echo $alert;
    exit();
  }

  $imgExtension = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
  $allowedExtension = ['jpg', 'jpeg', 'png'];

  if (in_array($imgExtension, $allowedExtension)) {
    $newImgName = uniqid("AVA-", true) . '.' . $imgExtension;
    $imgUploadPath = "../../avatar/$newImgName";
    move_uploaded_file($tmpName, $imgUploadPath);

    $sql = "INSERT INTO anggota(nama,gender,alamat,status,foto) VALUES( ? , ? , ? , ? , ? )";
    $statement = $connection->prepare($sql);
    $statement->execute([$nama, $gender, $alamat, $status, $newImgName]);
    $count = $statement->rowCount();

    if ($count == 1) {
      $alert = <<<ALERT
      <script>
      alert('Tambah Data Sucess!');
      window.location='../../anggota.php';
      </script>
      ALERT;

      echo $alert;
      exit();
    } else {
      $alert = <<<ALERT
        <script>
          alert('Tambah Data Gagal!');
          window.location='../../anggota-add.php?error=Data Gagal Ditambahkan!'
        </script>
      ALERT;

      echo $alert;
      exit();
    }
  } else {
    $alert = <<<ALERT
      <script>
        alert('Tambah Data Gagal!');
        window.location='../../anggota-add.php?error=Tipe File ini Dilarang!'
      </script>
    ALERT;

    echo $alert;
    exit();
  }
} else {
  $alert = <<<ALERT
    <script>
      alert('Tambah Data Gagal!');
      window.location='../../anggota-add.php?error=Bermasalah pada File Gambar'
    </script>
  ALERT;

  echo $alert;
  exit();
}
