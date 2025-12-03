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
      Tambah Buku
    </h1>
    <div class="flex text-sm ml-3 space-x-1">
      <a href="book.php" class="text-blue-500 hover:underline">Buku</a>
      <img src="icons/bt-b.svg" alt="" class="w-3.5">
      <span>Tambah</span>
    </div>
  </div>
</section>
<!-- END Header -->

<!-- Content -->
<div class="bg-white rounded p-5 my-6 border shadow text-sm">


  <form action="logic/buku/add.php" method="POST" id="form">
    <div class="w-full flex flex-wrap items-center mx-auto space-y-6">
      <div class="w-full flex items-center space-x-8">
        <!-- Judul Buku -->
        <div class="w-6/12">
          <label for="judul" class="block mb-2 text-xl font-medium">Judul Buku</label>
          <input type="text" id='judul' name='judul' class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm" placeholder="Masukkan Judul Buku">
        </div>

        <!-- Kategori -->
        <div class="w-6/12">
          <label for="kategori" class="block mb-2 text-xl font-medium">Kategori</label>
          <input type="text" id='kategori' name='kategori' class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm" placeholder="Masukkan Kategori">
        </div>
      </div>
      <div class="w-full flex items-center space-x-8">
        <!-- Pengarang -->
        <div class="w-6/12">
          <label for="pengarang" class="block mb-2 text-xl font-medium">Pengarang</label>
          <input type="text" id='pengarang' name='pengarang' class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm" placeholder="Masukkan pengarang">
        </div>

        <!-- Penerbit -->
        <div class="w-6/12">
          <label for="penerbit" class="block text-xl font-medium mb-2">Penerbit</label>
          <select name="penerbit" id="penerbit" class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm">
            <option value="">~~ Silahkan Pilih ~~</option>
            <option value="Media Baca">Media Baca</option>
            <option value="Media Kita">Media Kita</option>
            <option value="Media Cipta">Media Cipta</option>
            <option value="Graha">Graha</option>
          </select>
        </div>
      </div>

      <!-- Status -->
      <div class="w-full">
        <label class="block text-xl font-medium mb-2">Status</label>
        <div class="flex items-center space-x-4 mb-4">
          <div class="flex items-center">
            <input id="status-1" type="radio" name="status" value="Tersedia" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-purple-300 disabled:bg-blue-500 cursor-not-allowed" checked>
            <label for="status-1" class="block ml-2 text-sm font-medium text-gray-900 cursor-not-allowed">
              Tersedia
            </label>
          </div>
          <div class="flex items-center">
            <input id="status-2" type="radio" name="status" value="Dipinjam" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-purple-300 cursor-not-allowed" disabled>
            <label for="status-2" class="block ml-2 text-sm font-medium text-gray-900 cursor-not-allowed">
              Dipinjam
            </label>
          </div>
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
        <a href="book.php" class="inline-block border bg-yellow-400 hover:bg-yellow-500 rounded border-none py-3 px-6 mb-3 text-lg font-bold text-white">
          Kembali
        </a>
        <button type="button" onclick="reset();" class="border bg-red-500 hover:bg-red-600 rounded border-none py-3 px-6 mb-3 text-lg font-bold text-white">
          Ulang
        </button>
        <button class="border bg-blue-500 hover:bg-blue-600 rounded border-none py-3 px-6 mb-3 text-lg font-bold text-white" type='submit'>
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