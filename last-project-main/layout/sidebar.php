<!-- Desktop Sidebar -->
<section class="w-[261px] hidden xl:block shrink-0 h-screen sticky left-0 top-0 overflow-y-auto bg-white border-r-2 shadow-md border">
  <div class="flex flex-col">
    <!-- Side Logo -->
    <div class="sticky top-0 py-6 px-6 bg-white flex items-center justify-between text-[#7267f0] z-10 shadow-bottom">
      <div class="flex items-center space-x-3">
        <div class="relative w-9 h-6">
        </div>
        <h1 class="text-lg font-semibold">Perpustakaan</h1>
      </div>
      <span class="text-sm">O</span>
    </div>
    <!-- End Side Logo -->

    <div class="flex flex-col space-y-4 px-6 pt-4">
      <a href='index.php' class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all active py-2 text-white hover:text-white">
        <div class="w-3/12 text-center">
          <img src="icons/home-w.svg" alt="Home Icon" class="inline-block w-6 h-6 group-hover:ml-4">
          <!-- <Icon class="!w-6 !h-6 group-hover:!ml-4" /> -->
        </div>
        <div class="w-9/12 pt-1">
          Dashboard
        </div>
      </a>
      <div class="!mt-8">
        <h1 class="uppercase text-secondary text-sm">Master</h1>
      </div>
      <a href='book.php' class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all py-2 hover:bg-gray-100">
        <div class="w-3/12 text-center">
          <img src="icons/book-b.svg" alt="Book Icon" class="inline-block w-6 h-6 group-hover:ml-4">
        </div>
        <div class="w-9/12 pt-1">
          Buku
        </div>
      </a>
      <a href='anggota.php' class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all py-2 hover:bg-gray-100">
        <div class="w-3/12 text-center">
          <img src="icons/anggota-b.svg" alt="Book Icon" class="inline-block w-6 h-6 group-hover:ml-4">
        </div>
        <div class="w-9/12 pt-1">
          Anggota
        </div>
      </a>
      <div class="!mt-8">
        <h1 class="uppercase text-secondary text-sm">Transaksi</h1>
      </div>
      <a href='peminjaman.php' class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all py-2 hover:bg-gray-100">
        <div class="w-3/12 text-center">
          <img src="icons/peminjaman-b.svg" alt="Book Icon" class="inline-block w-6 h-6 group-hover:ml-4">
        </div>
        <div class="w-9/12 pt-1">
          Peminjaman
        </div>
      </a>
      <a href='pengembalian.php' class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all py-2 hover:bg-gray-100">
        <div class="w-3/12 text-center">
          <img src="icons/pengembalian-b.svg" alt="Book Icon" class="inline-block w-6 h-6 group-hover:ml-4">
        </div>
        <div class="w-9/12 pt-1">
          Pengembalian
        </div>
      </a>
    </div>
  </div>

</section>
<!-- END Desktop Sidebar -->

<!-- Mobile Sidebar -->
<div class="z-20 transition-all" id="mobile-sidebar" onclick="toggleSidebar(event)">
  <section class="w-[261px] block xl:hidden shrink-0 h-screen absolute z-50 -left-full top-0 overflow-y-auto bg-white border-r-2 shadow-md border">
    <div class="flex flex-col">
      <!-- Side Logo -->
      <div class="sticky top-0 py-6 px-6 bg-white flex items-center justify-between text-[#7267f0] z-10 shadow-bottom">
        <div class="flex items-center space-x-3">
          <div class="relative w-9 h-6">
          </div>
          <h1 class="text-lg font-semibold">Perpustakaan</h1>
        </div>
        <span class="text-sm">O</span>
      </div>
      <!-- End Side Logo -->

      <div class="flex flex-col space-y-4 px-6 pt-4">
        <a href='index.php' onclick="toggleSidebar(event)" class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all active py-2 text-white hover:text-white">
          <div class="w-3/12 text-center">
            <img src="icons/home-w.svg" alt="Home Icon" class="inline-block w-6 h-6 group-hover:ml-4">
            <!-- <Icon class="!w-6 !h-6 group-hover:!ml-4" /> -->
          </div>
          <div class="w-9/12 pt-1">
            Dashboard
          </div>
        </a>
        <div class="!mt-8">
          <h1 class="uppercase text-secondary text-sm">Master</h1>
        </div>
        <a href='book.php' onclick="toggleSidebar(event)" class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all py-2 hover:bg-gray-100">
          <div class="w-3/12 text-center">
            <img src="icons/book-b.svg" alt="Book Icon" class="inline-block w-6 h-6 group-hover:ml-4">
          </div>
          <div class="w-9/12 pt-1">
            Buku
          </div>
        </a>
        <a href='anggota.php' onclick="toggleSidebar(event)" class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all py-2 hover:bg-gray-100">
          <div class="w-3/12 text-center">
            <img src="icons/anggota-b.svg" alt="Book Icon" class="inline-block w-6 h-6 group-hover:ml-4">
          </div>
          <div class="w-9/12 pt-1">
            Anggota
          </div>
        </a>
        <div class="!mt-8">
          <h1 class="uppercase text-secondary text-sm">Transaksi</h1>
        </div>
        <a href='peminjaman.php' onclick="toggleSidebar(event)" class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all py-2 hover:bg-gray-100">
          <div class="w-3/12 text-center">
            <img src="icons/peminjaman-b.svg" alt="Book Icon" class="inline-block w-6 h-6 group-hover:ml-4">
          </div>
          <div class="w-9/12 pt-1">
            Peminjaman
          </div>
        </a>
        <a href='pengembalian.php' onclick="toggleSidebar(event)" class="flex items-center rounded hover:cursor-pointer hover:text-hover group transition-all py-2 hover:bg-gray-100">
          <div class="w-3/12 text-center">
            <img src="icons/pengembalian-b.svg" alt="Book Icon" class="inline-block w-6 h-6 group-hover:ml-4">
          </div>
          <div class="w-9/12 pt-1">
            Pengembalian
          </div>
        </a>
      </div>
    </div>

  </section>
</div>
<!-- END Mobile Sidebar -->