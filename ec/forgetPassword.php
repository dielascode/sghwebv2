<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style/costumer/loginRegist.css">
    <title>Lupa Password</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST" action="logic/forgetPasswordHandler.php">
                <h1>Lupa Password</h1>

                <input type="email" name="email" placeholder="Masukkan Email Anda" required />

                <button type="submit" name="reset">Kirim Tautan Setel Ulang</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Ingat Password?</h1>
                    <p>Kembali ke halaman login untuk masuk ke akun Anda.</p>
                    <a href="./login.php"><button class="ghost" id="signIn">Login</button></a>
                </div>
</html>