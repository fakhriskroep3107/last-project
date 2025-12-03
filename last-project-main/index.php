<?php
session_start();

if (!empty($_SESSION['id']) && !empty($_SESSION['email'])) {
} else {
  $alert = <<<ALERT
    <script>
      alert('Login Terlebih Dahulu, Untuk Mengakses Halaman Web!');
      window.location='auth/login.php';
    </script>
  ALERT;

  echo $alert;
  exit();
}
?>

<?php require_once __DIR__ . '/layout/top.php' ?>

<!-- Header -->
<section>
  <div class="flex items-center mt-4">
    <h1 class="text-2xl pr-4">
      Dashboard
    </h1>
  </div>
</section>
<!-- END Header -->

<!-- Content -->
<div class=" bg-white rounded p-5 my-6 border shadow text-sm">

  <h1>Selamat Datang!</h1>

</div>
<!-- END Content -->

<?php require_once __DIR__ . '/layout/bottom.php' ?>