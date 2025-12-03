<section class="sticky top-0 bg-secondary pt-4 z-10">
  <div class="flex items-center justify-between bg-white rounded p-4 shadow-lg border">
    <div class="flex items-center space-x-4">
      <div class="block xl:hidden shrink-0 hover:cursor-pointer" onclick="toggleSidebar(event)">
        <img src='icons/menu-b.svg' alt='Logo Copyright' id='menu-burger' class='inline-block h-6 w-6' />
      </div>
      <span class="block xl:hidden">|</span>
      <div class="hidden sm:flex items-center space-x-1">
        <img src='icons/copyright-b.svg' alt='Logo Copyright' class='inline-block h-6 w-6' />
        <p class="text-sm"><span class="font-medium">Kelompok Star</span> - TI P4</p>
      </div>
      <span class="hidden md:block">|</span>
      <span class="hidden lg:block text-sm font-medium">My Contact : </span>
      <div class="flex sm:hidden md:flex items-center space-x-4">
          <img src='icons/github-b.svg' alt='Logo Github' class='inline-block h-6 w-6 hover:text-hover hover:cursor-pointer' />
          <img src='icons/instagram-colorful.svg' alt='Logo Instagram' class='inline-block h-6 w-6 hover:text-hover hover:cursor-pointer' />
          <img src='icons/facebook-blue.svg' alt='Logo Facebook' class='inline-block h-6 w-6 hover:text-hover hover:cursor-pointer' />
          <img src='icons/gmail-colorful.svg' alt='Logo Gmail' class='inline-block h-6 w-6 hover:text-hover hover:cursor-pointer' />
      </div>
    </div>

    <div class="flex items-center space-x-2">
      <a href="auth/logout.php" class="inline-block shrink-0 border-x border-gray-400 mr-2 px-3 hover:text-hover hover:cursor-pointer">
        <img src="icons/logout-b.svg" alt="Logo Logout" class='inline-block h-6 w-6'>
        <span class="hidden lg:inline">Logout</span>
      </a>
      <div>
        <h4 class="text-sm font-medium"><?= $_SESSION['name'] ?></h4>
        <p class="text-xs text-right"><?= $_SESSION['email'] ?></p>
      </div>

      <a href="auth/logout.php" class="inline-block">
        <img alt="Gambar Profil" src="https://mui.com/static/images/avatar/1.jpg" class='inline-block h-9 w-9 rounded-full hover:text-hover hover:cursor-pointer' />
      </a>
    </div>
  </div>
</section>