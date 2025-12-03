<?php
session_start();

if (!empty($_SESSION['id']) && !empty($_SESSION['email'])) {
  require_once __DIR__ . '/db-config.php';

  if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = <<<SQL
    SELECT peminjaman.*, 
    anggota.nama as anggota, 
    books.judul as buku 
    FROM peminjaman 
    INNER JOIN anggota ON peminjaman.anggota_id = anggota.id
    INNER JOIN books ON peminjaman.book_id = books.id
    WHERE peminjaman.id = ?
  SQL;
    $statement = $connection->prepare($sql);
    $statement->execute([$id]);

    if ($row = $statement->fetch()) {
      $anggotaId = $row['anggota_id'];
      $anggota = $row['anggota'];
      $bookId = $row['book_id'];
      $buku = $row['buku'];
      $tglPinjam = $row['tgl_pinjam'];
      $tglKembali = $row['tgl_kembali'];

      //* Get All Anggota
      $sql = "SELECT * FROM anggota ORDER BY id DESC";
      $statement = $connection->prepare($sql);
      $statement->execute([]);

      $anggotas = $statement->fetchAll();

      //* Get All Books
      $sql = "SELECT * FROM books ORDER BY id DESC";
      $statement = $connection->prepare($sql);
      $statement->execute([]);

      $books = $statement->fetchAll();
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
      Ubah Peminjaman
    </h1>
    <div class="flex text-sm ml-3 space-x-1">
      <a href="anggota.php" class="text-blue-500 hover:underline">Peminjaman</a>
      <img src="icons/bt-b.svg" alt="" class="w-3.5">
      <span>Ubah</span>
    </div>
  </div>
</section>
<!-- END Header -->

<!-- Content -->
<div class="bg-white rounded p-5 my-6 border shadow text-sm">

  <form action="logic/peminjaman/edit.php" method="POST" id="form">
    <input type="text" class="hidden" name='id' value='<?= $id ?>'>
    <div class="w-full flex flex-wrap items-center mx-auto space-y-6">
      <div class="w-full flex items-center space-x-8">
        <!-- Anggota -->
        <div class="w-6/12">
          <label for="anggota_id" class="block text-xl font-medium mb-2">
            Anggota
          </label>
          <select name="anggota_id" id="anggota_id" class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm hover:cursor-not-allowed">
            <option value="">~~ Silahkan Pilih ~~</option>
            <?php foreach ($anggotas as $anggota) : ?>
              <option value="<?= $anggota['id'] ?>" <?= $anggotaId == $anggota['id'] ? 'selected' : '' ?>>
                <?= $anggota['nama'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Buku -->
        <div class="w-6/12">
          <label for="book_id" class="block text-xl font-medium mb-2">
            Buku
          </label>
          <select name="book_id" id="book_id" class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm hover:cursor-not-allowed">
            <option value="">~~ Silahkan Pilih ~~</option>
            <?php foreach ($books as $book) : ?>
              <option value="<?= $book['id'] ?>" <?= $bookId == $book['id'] ? 'selected' : '' ?>>
                <?= $book['judul'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="w-full flex items-center space-x-8">

        <!-- Tanggal Pinjam -->
        <div class="w-6/12">
          <label for="tgl_pinjam" class="block mb-2 text-xl font-medium">
            Tanggal Pinjam
          </label>
          <input type="date" id='tgl_pinjam' name='tgl_pinjam' class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm" placeholder="Masukkan Foto" value="<?= $tglPinjam ?>">
        </div>

        <!-- Tanggal Kembali -->
        <div class="w-6/12">
          <label for="tgl_kembali" class="block mb-2 text-xl font-medium">
            Tanggal Kembali
          </label>
          <input type="date" id='tgl_kembali' name='tgl_kembali' class="w-full p-3 px-4 text-black rounded-md border border-gray-400 focus:outline-purple-400 placeholder:text-sm" placeholder="Masukkan Foto" value="<?= $tglKembali ?>">
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
        <a href="peminjaman.php" class="inline-block border bg-yellow-400 hover:bg-yellow-500 rounded border-none py-3 px-6 mb-3 text-lg font-bold text-white">
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