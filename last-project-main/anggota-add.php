<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
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
      Tambah Anggota
    </h1>
    <div class="flex text-sm ml-3 space-x-1">
      <a href="anggota.php" class="text-blue-500 hover:underline">Anggota</a>
      <img src="icons/bt-b.svg" alt="" class="w-3.5">
      <span>Tambah</span>
    </div>
  </div>
</section>
<!-- END Header -->

<!-- Content -->
<div class="bg-white rounded p-5 my-6 border shadow text-sm">


  <form action="logic/anggota/add.php" method="POST" id="form" enctype="multipart/form-data">
    <div class="w-full flex flex-wrap items-center mx-auto space-y-6">
      <div class="w-full flex items-center space-x-8">
        <!-- Nama -->
        <div class="w-6/12">
          <label for="nama" class="block mb-2 text-xl font-medium">
            Nama
          </label>
          <input type="text" id='nama' name='nama' class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm" placeholder="Masukkan Nama">
        </div>

        <!-- Jenis Kelamin -->
        <div class="w-6/12">
          <label for="gender" class="block text-xl font-medium mb-2">
            Jenis Kelamin
          </label>
          <select name="gender" id="gender" class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm">
            <option value="">~~ Silahkan Pilih ~~</option>
            <option value="Pria">Pria</option>
            <option value="Wanita">Wanita</option>
          </select>
        </div>
      </div>

      <div class="w-full flex items-center space-x-8">
        <!-- Alamat -->
        <div class="w-6/12">
          <label for="alamat" class="block mb-2 text-xl font-medium">
            Alamat
          </label>
          <textarea name="alamat" id="alamat" rows="4" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-400 focus:outline-purple-400 focus:ring-blue-500" placeholder="Masukan Alamat..."></textarea>

        </div>

        <!-- Status -->
        <div class="w-6/12">
          <label class="block mb-2 text-xl font-medium">Status</label>
          <div class="flex items-center space-x-4">
            <div class="flex items-center">
              <input id="status-1" type="radio" name="status" value="Sedang Meminjam" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-purple-300 cursor-not-allowed" disabled>
              <label for="status-1" class="block ml-2 text-sm font-medium text-gray-900 cursor-not-allowed">
                Sedang Meminjam
              </label>
            </div>
            <div class="flex items-center">
              <input id="status-2" type="radio" name="status" value="Tidak Meminjam" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-purple-300 disabled:bg-blue-500 cursor-not-allowed" checked>
              <label for="status-2" class="block ml-2 text-sm font-medium text-gray-900 cursor-not-allowed">
                Tidak Meminjam
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto -->
      <div class="w-full">
        <div class="w-6/12 pr-4">
          <label for="foto" class="block mb-2 text-xl font-medium">
            Foto
          </label>
          <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-purple-600 focus:outline-none" type="file" accept="image/*" name='foto' id=" foto">
          <p class="mt-1 text-sm text-gray-400">SVG, PNG, JPG atau JPEG (MAX. 800x400px).</p>
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
          <button type='submit' class="border bg-blue-500 hover:bg-blue-600 rounded border-none py-3 px-6 mb-3 text-lg font-bold text-white">
            Submit
          </button>
        </div>

      </div>
  </form>


</div>
<!-- END Content -->

<?php require_once __DIR__ . '/layout/bottom.php' ?>

<script>
  function reset() {
    document.getElementById("form").reset();
  }
</script>