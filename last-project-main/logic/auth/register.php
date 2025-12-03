<?php
session_start();

require_once __DIR__ . '/../../db-config.php';

// var_dump(isset($_POST['email']) && isset($_POST['password']));
// exit();

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {

  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $name = validate($_POST['name']);
  $email = validate($_POST['email']);
  $password = validate($_POST['password']);

  if (empty($name)) { //! if "Name" empty, Redirect.
    header("Location: register.php?error=Nama wajib diisi!");
    exit();
  } else if (empty($email)) { //! if "Email" empty, Redirect.
    header("Location: register.php?error=Email wajib diisi!");
    exit();
  } else if (empty($password)) { //! if "Password" empty, Redirect.
    header("Location: register.php?error=Password wajib diisi!");
    exit();
  } else {

    //! Insert Data User
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $statement = $connection->prepare($sql);
    $statement->execute([$name, $email, $password]);
    $count = $statement->rowCount();

    if ($count == 1) {

      //! Find Registered User
      $sql = "SELECT * FROM users WHERE email=? AND password=?";
      $statement = $connection->prepare($sql);
      $statement->execute([$email, $password]);

      if ($row = $statement->fetch()) { //! if "find user query" success
        //! Create Session data by Logged In User
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];

        header("Location: ../../index.php"); //! Redirect to "Home Page"
        exit();
      } else {
        header("Location: login.php?error=Login Otomatis Gagal, coba untuk lakukan login kembali!");
        exit();
      }
    } else {
      header("Location: register.php?error=Gagal mendaftarkan pengguna, silahkan kontak developer!");
      exit();
    }
  }
} else {
  header("Location: register.php?");
  exit();
}
