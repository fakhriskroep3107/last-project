<?php
session_start();
require_once '../config/database.php';
require_once '../config/helpers.php';
require_once '../middleware/auth.php';

requireGuest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $password = clean($_POST['password'] ?? '');
    
    // Validasi
    $errors = [];
    if (empty($name)) $errors[] = "Nama wajib diisi";
    if (empty($email)) $errors[] = "Email wajib diisi";
    if (empty($password)) $errors[] = "Password wajib diisi";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Format email tidak valid";
    
    if (empty($errors)) {
        // Cek email sudah terdaftar
        $check = fetchOne("SELECT id FROM users WHERE email = ?", [$email]);
        
        if ($check) {
            $error = "Email sudah terdaftar!";
        } else {
            // Insert user baru
            $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')";
            $userId = insert($sql, [$name, $email, $password]);
            
            if ($userId) {
                // Auto login
                $user = fetchOne("SELECT * FROM users WHERE id = ?", [$userId]);
                loginUser($user);
                redirect('../user/dashboard.php', 'Registrasi berhasil! Selamat datang.', 'success');
            } else {
                $error = "Gagal mendaftar. Silakan coba lagi.";
            }
        }
    } else {
        $error = implode(", ", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Poppins', sans-serif; }
        .bg-img { background-image: url('../img/bg.jpg'); background-size: cover; }
    </style>
</head>
<body>
    <div class="flex min-h-screen overflow-y-auto">
        <div class="hidden md:block w-5/12 bg-img shrink-0">
            <div class="bg-black/40 h-full"></div>
        </div>

        <div class="w-full md:w-7/12 bg-[#0063CC] text-white pb-10">
            <div class="flex flex-col items-center">
                <div class="flex space-x-7 mt-7 mb-16"></div>
                <div class="mb-9">
                    <h1 class="text-4xl font-bold">Buat Akun Baru</h1>
                </div>

                <div class="w-7/12 md:w-6/12">
                    <form action="" method="POST" class="flex flex-col space-y-3">
                        <div>
                            <label for="name" class="block mb-1">Nama Lengkap</label>
                            <input type="text" id="name" name="name" 
                                   class="w-full p-2 px-4 text-black rounded-md focus:outline-cyan-500" 
                                   placeholder="Masukkan Nama"
                                   value="<?= $_POST['name'] ?? '' ?>">
                        </div>

                        <div>
                            <label for="email" class="block mb-1">Email</label>
                            <input type="email" id="email" name="email" 
                                   class="w-full p-2 px-4 text-black rounded-md focus:outline-cyan-500" 
                                   placeholder="Masukkan Email"
                                   value="<?= $_POST['email'] ?? '' ?>">
                        </div>

                        <div>
                            <label for="password" class="block mb-1">Password</label>
                            <input type="password" id="password" name="password" 
                                   class="w-full p-2 px-4 text-black rounded-md focus:outline-cyan-500" 
                                   placeholder="Masukkan Password">
                        </div>

                        <?php if (isset($error)): ?>
                            <div class="bg-[#ffd4d4] p-2 rounded text-center">
                                <span class="text-red-600"><?= $error ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="pt-3">
                            <button type="submit" 
                                    class="border bg-blue-400 hover:bg-blue-300 w-full rounded-full py-2 mb-3 font-bold">
                                Daftar
                            </button>
                            <p class="text-center text-sm">
                                Sudah punya akun? 
                                <a href="login.php" class="text-blue-300 hover:underline">Login</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>