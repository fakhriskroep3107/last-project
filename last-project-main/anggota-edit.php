<?php
session_start();

if (!empty($_SESSION['id']) && !empty($_SESSION['email'])) {
  require_once __DIR__ . '/db-config.php';

  if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM anggota WHERE id = ?";
    $statement = $connection->prepare($sql);
    $statement->execute([$id]);

    if ($row = $statement->fetch()) {
      $nama = $row['nama'];
      $gender = $row['gender'];
      $alamat = $row['alamat'];
      $status = $row['status'];
      $foto = $row['foto'];
    } else {
      $alert = <<<ALERT
        <script>
          alert('Data yang ingin di edit tidak ditemukan!');
          window.location='anggota.php';
        </script>
      ALERT;

      echo $alert;
      exit();
    }
  } else {
    $alert = <<<ALERT
        <script>
          alert('Data yang ingin di edit tidak ditemukan!');
          window.location='anggota.php';
        </script>
      ALERT;

    echo $alert;
    exit();
  }
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
    <h1 class="text-2xl pr-4 border-r border-gray-300">
      Ubah Anggota
    </h1>
    <div class="flex text-sm ml-3 space-x-1">
      <a href="anggota.php" class="text-blue-500 hover:underline">Anggota</a>
      <img src="icons/bt-b.svg" alt="" class="w-3.5">
      <span>Ubah</span>
    </div>
  </div>
</section>
<!-- END Header -->

<!-- Content -->
<div class="bg-white rounded p-5 my-6 border shadow text-sm">


  <form action="logic/anggota/edit.php" method="POST" id="form" enctype="multipart/form-data">
    <input type="text" class="hidden" name='id' value='<?= $id ?>'>
    <div class="w-full flex flex-wrap items-center mx-auto space-y-6">
      <div class="w-full flex items-center space-x-8">
        <!-- Nama -->
        <div class="w-6/12">
          <label for="nama" class="block mb-2 text-xl font-medium">
            Nama
          </label>
          <input type="text" id='nama' name='nama' class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm" placeholder="Masukkan Nama" value='<?= $nama ?>'>
        </div>

        <!-- Jenis Kelamin -->
        <div class="w-6/12">
          <label for="gender" class="block text-xl font-medium mb-2">
            Jenis Kelamin
          </label>
          <select name="gender" id="gender" class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm">
            <option value="">~~ Silahkan Pilih ~~</option>
            <option value="Pria" <?= $gender == 'Pria' ? 'selected' : '' ?>>Pria</option>
            <option value="Wanita" <?= $gender == 'Wanita' ? 'selected' : '' ?>>Wanita</option>
          </select>
        </div>
      </div>

      <div class="w-full flex items-center space-x-8">
        <!-- Alamat -->
        <div class="w-6/12">
          <label for="alamat" class="block mb-2 text-xl font-medium">
            Alamat
          </label>
          <textarea name="alamat" id="alamat" rows="4" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-400 focus:outline-purple-400 focus:ring-blue-500" placeholder="Masukan Alamat..."><?= $alamat ?></textarea>

        </div>

        <!-- Status -->
        <div class="w-6/12">
          <label class="block mb-2 text-xl font-medium">Status</label>
          <div class="flex items-center space-x-4">
            <div class="flex items-center">
              <input id="status-1" type="radio" name="status" value="Sedang Meminjam" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-purple-300" <?= $status == 'Sedang Meminjam' ? 'checked' : '' ?>>
              <label for="status-1" class="block ml-2 text-sm font-medium text-gray-900">
                Sedang Meminjam
              </label>
            </div>
            <div class="flex items-center">
              <input id="status-2" type="radio" name="status" value="Tidak Meminjam" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-purple-300" <?= $status == 'Tidak Meminjam' ? 'checked' : '' ?>>
              <label for="status-2" class="block ml-2 text-sm font-medium text-gray-900">
                Tidak Meminjam
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto -->
      <div class="w-full flex items-center space-x-4">
        <div class="w-6/12 pr-4">
          <label for="foto" class="block mb-2 text-xl font-medium">
            Foto
          </label>
          <p class="mt-1 text-sm text-red-400">*Tidak perlu diisi, jika tidak ingin mengubah gambar</p>
          <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-purple-600 focus:outline-none" type="file" accept="image/*" name='foto' id=" foto">
          <p class="mt-1 text-sm text-gray-400">SVG, PNG, JPG atau JPEG (MAX. 800x400px).</p>
        </div>
        <div class="w-6/12">
          <img src="avatar/<?= $foto ?>" alt="Foto Anggota" class="inline-block w-28 h-28">
        </div>
      </div>

      <div class="w-full text-center">
        <?php if (!empty($_GET['error'])) : ?>
          <div class="w-max mx-auto my-3 px-3 p-2 bg-[#ffd4d4] rounded text-center">
            <span class="text-xl text-red-600"><?= $_GET['error'] ?></span>
          </div>
        <?php endif; ?>
      </div>

      <div class="w-full flex justify-end space-x-4">
        <a href="anggota.php" class="inline-block border bg-yellow-400 hover:bg-yellow-500 rounded border-none py-3 px-6 mb-3 text-lg font-bold text-white">
          Kembali
        </a>
        <button type="button" onclick="reset();" class="border bg-red-500 hover:bg-red-600 rounded border-none py-3 px-6 mb-3 text-lg font-bold text-white">
          Ulang
        </button>
        <button class="border bg-blue-500 hover:bg-blue-600 rounded border-none py-3 px-6 mb-3 text-lg font-bold text-white" type='submit'>
          Ubah
        </button>
      </div>

    </div>
  </form>


</div>
<!-- END Content -->

<?php require_once __DIR__ . '/layout/bottom.php' ?>

<script>
  function reset() {
    console.log('clicked');
    let form = document.getElementById("form").reset();
  }
</script>