<?php
require_once "config/connection.php";
require_once 'logic/class/authAdmin.php';

$db = new Database();
$conn = $db->getConnection();
$auth = new Auth($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($email, $password)) {
        header("Location: admin/index.php");
        session_regenerate_id(true);
        $_SESSION['login'] = true;
    } else {
        $error = "Username atau password salah!";
    }
}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AgriNexa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .brand-color {
            color: #1D4D32;
            /* Hijau gelap sesuai gambar dashboard */
        }

        .bg-brand {
            background-color: #1D4D32;
        }

        .bg-brand:hover {
            background-color: #163a26;
        }

        .input-focus:focus {
            border-color: #1D4D32;
            ring-color: #1D4D32;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Bagian Header/Logo -->
        <div class="p-8 pb-4 text-center">
            <div class="flex items-center justify-center gap-3 mb-6">
                <!-- Mockup Logo -->
                <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center p-2 border border-gray-200">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-green-700">
                        <path d="M12 2L3 9V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V9L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9 21V12H15V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold brand-color tracking-tight">AgriNexa</h1>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Selamat Datang Kembali</h2>
            <p class="text-sm text-gray-500 mt-1">Silakan masuk untuk mengelola data pertanian Anda</p>
        </div>
        <?php  if(isset($error)) : ?>
                <p style="color:red"><?php echo $error?></p>
            <?php  endif; ?>
        <!-- Form Login -->
        <form class="p-8 pt-4 space-y-5" method="post">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="nama@email.com"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-800 focus:border-transparent transition duration-200 input-focus">
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                </div>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-800 focus:border-transparent transition duration-200 input-focus">
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="remember" class="w-4 h-4 text-green-800 border-gray-300 rounded focus:ring-green-700">
                <label for="remember" class="ml-2 text-sm text-gray-600">Ingat perangkat ini</label>
            </div>

            <button
                type="submit"
                class="w-full py-3 px-4 bg-brand text-white font-bold rounded-lg shadow-lg transform transition active:scale-[0.98] hover:shadow-green-900/20">
                Masuk ke Dashboard
            </button>
        </form>
    </div>

    <!-- Alert Box (Hidden by default) -->
    <!-- <div id="messageBox" class="fixed top-5 right-5 transform translate-x-[150%] transition-transform duration-300 bg-white border-l-4 border-green-600 p-4 shadow-2xl rounded flex items-center gap-3">
        <div class="text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div>
            <p class="font-bold text-gray-800">Berhasil!</p>
            <p class="text-sm text-gray-600">Mengarahkan Anda ke dashboard...</p>
        </div>
    </div> -->

    <!-- <script>
        function handleLogin(e) {
            e.preventDefault();
            const messageBox = document.getElementById('messageBox');
            
            // Animasi simulasi login berhasil
            messageBox.style.transform = 'translateX(0)';
            
            setTimeout(() => {
                messageBox.style.transform = 'translateX(150%)';
                // Di sini nanti Dila bisa tambahkan window.location.href ke halaman dashboard PHP/Express kamu
            }, 3000);
        }
    </script> -->
</body>

</html>