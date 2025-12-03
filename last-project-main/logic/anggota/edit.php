<?php

require __DIR__ . '/../../db-config.php';
require_once __DIR__ . '/../requiredFunction.php';

$id = $_POST['id'];

if (empty($_POST['nama'])) {
  required(name: 'Nama', file: 'anggota-edit', id: $id);
}
if (empty($_POST['gender'])) {
  required(name: 'Gender', file: 'anggota-edit', id: $id);
}
if (empty($_POST['alamat'])) {
  required(name: 'Alamat', file: 'anggota-edit', id: $id);
}
if (empty($_POST['status'])) {
  required(name: 'Status', file: 'anggota-edit', id: $id);
}

$nama = $_POST['nama'];
$gender = $_POST['gender'];
$alamat = $_POST['alamat'];
$status = $_POST['status'];

// var_dump(
//   $id,
//   $nama,
//   $gender,
//   $alamat,
//   $status
// );
// exit();

if (!empty($_FILES['foto']['name'])) {
  $imgName = $_FILES['foto']['name'];
  $imgSize = $_FILES['foto']['size'];
  $tmpName = $_FILES['foto']['tmp_name'];
  $error = $_FILES['foto']['error'];

  if ($error === 0) {
    if ($imgSize > 125000) {
      $alert = <<<ALERT
      <script>
        alert('Edit Data Gagal!');
        window.location='../../anggota-edit.php?id=$id&error=Ukuran Gambar Terlalu Besar!'
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

      $sql = "UPDATE anggota SET nama = ?, gender = ?, alamat = ?, status = ?, foto = ? WHERE id = ?";
      $statement = $connection->prepare($sql);
      $statement->execute([$nama, $gender, $alamat, $status, $newImgName, $id]);
      $count = $statement->rowCount();

      if ($count == 1) {
        $alert = <<<ALERT
      <script>
      alert('Edit Data Sucess!');
      window.location='../../anggota.php';
      </script>
      ALERT;

        echo $alert;
        exit();
      } else {
        $alert = <<<ALERT
        <script>
          alert('Edit Data Gagal!');
          window.location='../../anggota-edit.php?id=$id&error=Data Gagal Ditambahkan!'
        </script>
      ALERT;

        echo $alert;
        exit();
      }
    } else {
      $alert = <<<ALERT
      <script>
        alert('Edit Data Gagal!');
        window.location='../../anggota-edit.php?id=$id&error=Tipe File ini Dilarang!'
      </script>
    ALERT;

      echo $alert;
      exit();
    }
  } else {
    $alert = <<<ALERT
    <script>
      alert('Edit Data Gagal!');
      window.location='../../anggota-edit.php?id=$id&error=Bermasalah pada File Gambar'
    </script>
  ALERT;

    echo $alert;
    exit();
  }
} else { //* Jika tidak ada gambar yang diupload
  $sql = "UPDATE anggota SET nama = ?, gender = ?, alamat = ?, status = ? WHERE id = ?";

  $statement = $connection->prepare($sql);
  $updatedData = $statement->execute([$nama, $gender, $alamat, $status, $id]);

  // var_dump($updatedData);
  // exit();

  if ($updatedData == true) {
    $alert = <<<ALERT
      <script>
        alert('Edit Data Sucess!');
        window.location='../../anggota.php'
      </script>
    ALERT;

    echo $alert;
    exit();
  } else {
    exit();
    $alert = <<<ALERT
      <script>
        alert('Edit Data Gagal!');
        window.location='../../anggota-edit.php?id=$id&error=Edit Data Gagal!'
      </script>
    ALERT;

    echo $alert;
    exit();
  }
}
