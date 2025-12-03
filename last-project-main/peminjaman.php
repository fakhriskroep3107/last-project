<?php
session_start();

if (!empty($_SESSION['id']) && !empty($_SESSION['email'])) {
  require_once __DIR__ . '/db-config.php';

  $search = !empty($_POST['search']) ? $_POST['search'] : '';

  $searchQuery = <<<SEARCHQUERY
    WHERE anggota.nama LIKE :search
    OR books.judul LIKE :search
    OR peminjaman.tgl_pinjam LIKE :search
    OR peminjaman.tgl_kembali LIKE :search
  SEARCHQUERY;

  $perPage = 5;

  //* Count Total Data Peminjaman
  $sql = <<<SQL
    SELECT count(*) as total FROM peminjaman
    INNER JOIN anggota ON peminjaman.anggota_id = anggota.id
    INNER JOIN books ON peminjaman.book_id = books.id
    $searchQuery
  SQL;
  $statement = $connection->prepare($sql);
  $statement->execute([':search' => "%$search%"]);
  $totalResults = $statement->fetchColumn();

  //* Total Pages
  //! if no result set Total Page to 1 (not Zero)
  $totalPages = ceil($totalResults / $perPage) != 0 ? ceil($totalResults / $perPage) : 1;

  //* Current page
  //! Jika page kurang dari 1 / kosong, Set "$currentPage" to 1
  $currentPage = empty($_POST['page']) || $_POST['page'] < 1 ? 1 : $_POST['page'];

  // var_dump($currentPage);
  // var_dump($totalPages);

  $startingLimits = ($currentPage - 1) * $perPage;

  //* Query to fetch peminjaman
  $sql = <<<SQL
    SELECT peminjaman.*, 
    anggota.nama as anggota, 
    books.judul as buku 
    FROM peminjaman 
    INNER JOIN anggota ON peminjaman.anggota_id = anggota.id
    INNER JOIN books ON peminjaman.book_id = books.id
    $searchQuery
    ORDER BY peminjaman.id DESC 
    LIMIT $startingLimits,$perPage;
  SQL;
  $statement = $connection->prepare($sql);
  $statement->execute([':search' => "%$search%"]);
  $peminjamans = $statement->fetchAll();
  $rows = $statement->rowCount();
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
      List Peminjaman
    </h1>
  </div>
</section>
<!-- END Header -->

<!-- Content -->
<div class=" bg-white rounded p-5 my-6 border shadow text-sm">

  <!-- Buttons -->
  <div class="flex items-center justify-between">

    <!-- Add, Print Button -->
    <div class="flex items-center justify-end space-x-3">
      <a href='' class="flex space-x-2 items-center bg-green-500 hover:bg-green-800 text-white p-2.5 px-4 rounded-lg shadow-md hover:shadow-none font-bold mb-4">
        <img src="icons/refresh-w.svg" alt="Refresh Logo" class="w-4 h-4">
        <span class='hidden md:block'>Refresh</span>
      </a>
      <button type='button' onclick="printAll();" class="flex space-x-2 items-center bg-yellow-500 hover:bg-yellow-800 text-white p-2.5 px-4 rounded-lg shadow-md hover:shadow-none font-bold mb-4">
        <img src="icons/print-w.svg" alt="Print Logo" class="w-4 h-4">
        <span class='hidden md:block'>Cetak</span>
      </button>
      <a href='peminjaman-add.php' class="flex space-x-2 items-center bg-blue-500 hover:bg-blue-800 text-white p-2.5 px-4 rounded-lg shadow-md hover:shadow-none font-bold mb-4">
        <img src="icons/plus-w.svg" alt="Plus Logo" class="w-4 h-4">
        <span class='hidden md:block'>Tambah</span>
      </a>
    </div>
    <!-- END Add, Print Button -->

    <!-- Search Input -->
    <form action="peminjaman.php" method="POST" class="flex items-center">
      <label for="search" class="sr-only">Search</label>
      <div class="relative w-full">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <img src="icons/search-gray.svg" alt="Search Icon" class="h-5 w-5">
        </div>
        <input type="text" name='search' id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:outline-purple-400 block w-full pl-10 p-2.5" placeholder="Search" value='<?= !empty($_POST['search']) ? $_POST['search'] : '' ?>'>
      </div>
      <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-purple-700 rounded-lg border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300">
        <img src="icons/search-w.svg" alt="Search Icon" class="h-5 w-5">
      </button>
    </form>
    <!-- END Search Input -->
  </div>
  <!-- END Buttons -->

  <!-- Table Data -->
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-gray-200">
        <tr>
          <th scope="col" class="px-6 py-3">
            Anggota
          </th>
          <th scope="col" class="px-6 py-3">
            Buku
          </th>
          <th scope="col" class="px-6 py-3">
            Tanggal Pinjam
          </th>
          <th scope="col" class="px-6 py-3">
            Tanggal Kembali
          </th>
          <!-- <th scope="col" class="px-6 py-3 text-center">
            Aksi
          </th> -->
          <th scope="col" class="px-6 py-3">
            <span class="sr-only">Action</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php if ($rows == 0) : ?>
          <tr class="bg-white border-b">
            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center" colspan="6">Data Tidak Ditemukan.</td>
          </tr>
        <?php else : ?>
          <?php foreach ($peminjamans as $peminjaman) : ?>
            <tr class="bg-white border-b">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                <?= $peminjaman['anggota'] ?>
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                <?= $peminjaman['buku'] ?>
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                <?= $peminjaman['tgl_pinjam'] ?>
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                <?= $peminjaman['tgl_kembali'] ?>
              </th>

              <!-- Action Buttons -->
              <td class="flex justify-content-evenly items-center space-x-1.5 py-4 px-6">

                <button type="button" onclick="printSingle(<?= $peminjaman['id'] ?>)" class="bg-yellow-500 hover:bg-yellow-600 p-2.5 rounded font-medium text-white">
                  <img src="icons/print-w.svg" alt="Print Logo" class="w-5 h-5">
                </button>
                <span> - </span>

                <a href="peminjaman-edit.php?id=<?= $peminjaman['id'] ?>" class="bg-green-600 hover:bg-green-700 p-2.5 rounded font-medium text-white">
                  <img src="icons/edit-w.svg" alt="Edit Logo" class="w-5 h-5">
                </a>
                <span> - </span>

                <form action="logic/peminjaman/delete.php" method="POST" class='m-0'>
                  <input type="text" class='hidden' name='id' value='<?= $peminjaman['id'] ?>'>
                  <button type="submit" onclick="return confirm('Apakah yakin data akan di hapus?')" class="block bg-red-600 hover:bg-red-700 p-2.5 rounded font-medium text-white">
                    <img src="icons/trash-w.svg" alt="Remove Logo" class="w-5 h-5">
                  </button>
                </form>
                <span> - </span>

                <form action="logic/peminjaman/kembalikan.php" method="POST" class='m-0'>
                  <input type="text" class='hidden' name='id' value='<?= $peminjaman['id'] ?>'>
                  <input type="text" class='hidden' name='anggota_id' value='<?= $peminjaman['anggota_id'] ?>'>
                  <input type="text" class='hidden' name='book_id' value='<?= $peminjaman['book_id'] ?>'>
                  <input type="text" class='hidden' name='tgl_pinjam' value='<?= $peminjaman['tgl_pinjam'] ?>'>
                  <input type="text" class='hidden' name='tgl_kembali' value='<?= $peminjaman['tgl_kembali'] ?>'>
                  <button type="submit" onclick="return confirm('Yakin ingin Mengambalikan Buku?')" class="bg-blue-600 hover:bg-blue-700 p-2.5 rounded font-medium text-white font-semibold">
                    Kembalikan
                  </button>
                </form>

              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
  <!-- END Table Data -->

  <!-- Pagination -->
  <div class="flex items-center justify-between">
    <!-- Help text -->
    <span class="text-sm text-gray-700">
      Jumlah Data : <span class="font-semibold text-gray-900"><?= $totalResults ?></span>
    </span>
    <!-- Buttons -->
    <div class="inline-flex mt-2 xs:mt-0">
      <?php $previousPage = $currentPage - 1 ?>
      <?php $nextPage = $currentPage + 1 ?>

      <form action="" method="POST" class="inline-block">
        <?php if (!empty($_POST['search'])) : ?>
          <input type="text" name='search' class="hidden" value="<?= $_POST['search'] ?>">
        <?php endif; ?>
        <input type="text" name='page' class="hidden" value="<?= $previousPage ?>">
        <button type="submit" class="py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 <?= $currentPage == 1 ? '!hidden' : '' ?>">
          Previous
        </button>
      </form>

      <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++) : ?>
        <form action="" method="POST" class="inline-block">
          <?php if (!empty($_POST['search'])) : ?>
            <input type="text" name='search' class="hidden" value="<?= $_POST['search'] ?>">
          <?php endif; ?>
          <input type="text" name='page' class="hidden" value="<?= $pageNumber ?>">
          <button type="submit" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 <?= $pageNumber == $currentPage ? 'bg-blue-400 !text-white border-blue-400 hover:bg-blue-500 hover:text-white' : '' ?>">
            <?= $pageNumber; ?>
          </button>
        </form>
      <?php endfor; ?>

      <form action="" method="POST" class="inline-block">
        <?php if (!empty($_POST['search'])) : ?>
          <input type="text" name='search' class="hidden" value="<?= $_POST['search'] ?>">
        <?php endif; ?>
        <input type="text" name='page' class="hidden" value="<?= $nextPage ?>">
        <button type="submit" class="py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 <?= $currentPage == $totalPages ? '!hidden' : '' ?>">Next</button>
      </form>

    </div>

  </div>
  <!-- END Pagination -->

</div>
<!-- END Content -->

<?php require_once __DIR__ . '/layout/bottom.php' ?>

<script>
  function printAll() {
    let printWindow = window.open('http://localhost:3000/project/tugas-akhir/print/peminjaman-all.php', '_blank', `width=${screen.availWidth}`, `height=${screen.availHeight}`);

    printWindow.print();
  }

  function printSingle(id) {
    let printWindow = window.open(`http://localhost:3000/project/tugas-akhir/print/peminjaman-single.php?id=${id}`, '_blank', `width=${screen.availWidth}`, `height=${screen.availHeight}`);

    printWindow.print();
  }
</script>