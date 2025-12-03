<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
      background-color: #f7f7f7;
    }

    .backdrop::after {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      content: '';
    }

    .font-montserrat {
      font-family: 'Montserrat', sans-serif;
    }

    .bg-secondary {
      background-color: #f7f7f7;
    }

    .text-primary {
      color: #827aa1;
    }

    .text-secondary {
      color: #a6a4b0;
    }

    .shadow-bottom {
      box-shadow: 0 0 10px 7px rgb(255 255 255 / 70%);
    }

    .text-hover {
      color: #7367f0;
    }

    .active {
      position: relative;
      background: linear-gradient(118deg, #7367f0, rgba(115, 103, 240, 0.7));
      box-shadow: 0 0 10px 1px rgb(115 103 240 / 70%);
    }
  </style>
</head>

<body>

  <div class="flex text-primary font-montserrat">
    <!-- LEFT SIDE -->
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/sidebar.php' ?>
    <!-- END Sidebar -->

    <!-- RIGHT SIDE -->
    <section class="w-full mx-5">
      <!-- Navbar -->
      <?php require_once __DIR__ . '/navbar.php' ?>
      <!-- END Navbar -->