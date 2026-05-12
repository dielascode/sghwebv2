<?php 

session_start();

// get token from URL

$token = $_GET['token'] ?? 'null';

if (!$token) {
    $_SESSION['error'] = "Gagal atau Token tidak ditemukan";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style/costumer/loginRegist.css">
    <title>Reset Password</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST" action="logic/class/handleresetPassword.php">
                <h1>Reset Password</h1>

                <?php if (isset($_SESSION['error'])): ?>
                    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
                <?php endif; ?>

                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="password" name="new_password" placeholder="Masukkan Password Baru" required />
                <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" required />

                <button type="submit" name="reset">Setel Ulang Password</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Ingat Password?</h1>
                    <p>Kembali ke halaman login untuk masuk ke akun Anda.</p>
                    <a href="./login.php"><button class="ghost" id="signIn">Login</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>