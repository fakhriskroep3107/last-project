<?php
session_start();
require_once '../config/database.php';
require_once '../config/helpers.php';
require_once '../middleware/auth.php';

// Redirect jika sudah login
requireGuest();

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean($_POST['email'] ?? '');
    $password = clean($_POST['password'] ?? '');
    
    // Validasi input
    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi!";
    } else {
        // Cek user di database
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $user = fetchOne($sql, [$email]);
        
        if ($user && $password === $user['password']) {
            // Login berhasil - set session
            loginUser($user);
            
            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                redirect('../admin/dashboard.php', 'Login berhasil! Selamat datang Admin.', 'success');
            } else {
                redirect('../user/dashboard.php', 'Login berhasil! Selamat datang.', 'success');
            }
        } else {
            $error = "Email atau password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Poppins', sans-serif; }
        .bg-img {
            background-image: url('../img/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen overflow-y-auto">
        <!-- Left Side - Image -->
        <div class="hidden md:block w-5/12 bg-img shrink-0">
            <div class="bg-black/40 h-full flex justify-center items-center">
                <!-- Logo bisa ditambahkan di sini -->
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full md:w-7/12 bg-[#0063CC] text-white pb-10">
            <div class="flex flex-col items-center">
                <!-- Logo -->
                <div class="flex space-x-7 mt-7 mb-16"></div>

                <!-- Title -->
                <div class="mb-9">
                    <h1 class="text-4xl font-bold">Selamat Datang</h1>
                    <p class="text-center text-sm mt-2 opacity-80">Silakan login untuk melanjutkan</p>
                </div>

                <!-- Form -->
                <div class="w-7/12 md:w-6/12">
                    <form action="" method="POST" class="flex flex-col space-y-3">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block mb-1">Email</label>
                            <input type="email" id="email" name="email" 
                                   class="w-full p-2 px-4 text-black rounded-md focus:outline-cyan-500 placeholder:text-sm" 
                                   placeholder="Masukkan Email"
                                   value="<?= $_POST['email'] ?? '' ?>">
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block mb-1">Password</label>
                            <input type="password" id="password" name="password" 
                                   class="w-full p-2 px-4 text-black rounded-md focus:outline-cyan-500 placeholder:text-sm" 
                                   placeholder="Masukkan Password">
                        </div>

                        <!-- Error Message -->
                        <?php if (isset($error)): ?>
                            <div class="bg-[#ffd4d4] p-2 rounded text-center">
                                <span class="text-red-600"><?= $error ?></span>
                            </div>
                        <?php endif; ?>

                        <!-- Submit Button -->
                        <div class="pt-3">
                            <button type="submit" 
                                    class="border bg-blue-400 hover:bg-blue-300 w-full rounded-full border-none py-2 mb-3 font-bold transition">
                                Masuk
                            </button>
                            <div>
                                <p class="text-center text-sm">
                                    Belum punya akun? 
                                    <a href="register.php" class="text-blue-300 hover:underline">Buat Akun</a>
                                </p>
                            </div>
                        </div>
                    </form>

                    <!-- Info Demo -->
                    <div class="mt-8 text-sm bg-white/10 p-4 rounded">
                        <p class="font-semibold mb-2">Akun Demo:</p>
                        <p>📧 Admin: admin@perpus.com / admin123</p>
                        <p>👤 User: user@perpus.com / user123</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>