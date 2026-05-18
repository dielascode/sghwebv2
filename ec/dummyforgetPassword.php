<?php 

session_name('sghwebv2_session');
session_start();

// Clear success message setelah ditampilkan
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cek Email Kamu</title>
  <link rel="stylesheet" href="style\costumer\dummyforgetPassword.css" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet" />
</head>
<body>
  <div class="bg-blob blob-1"></div>
  <div class="bg-blob blob-2"></div>

  <main class="card">
    <div class="illustration-wrap">
      <img
        src="images/Messages-rafiki.png"
        alt="Check your email illustration"
        class="illustration"
      />
    </div>

    <h1 class="title">Silahkan Cek Email Kamu!</h1>
    <p class="subtitle">
      Untuk melakukan reset password akun, silahkan cek email lalu tekan
      link yang diberikan.
    </p>
  </main>
</body>
</html>
