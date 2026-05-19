<?php 
session_name('sghwebv2_session');
session_start();

// Jika tidak ada success message, redirect ke login
if (!isset($_SESSION['success'])) {
    header("Location: login.php");
    exit();
}

$successMessage = $_SESSION['success'];
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/costumer/loginRegist.css">
    <title>Reset Password Berhasil</title>
    <style>
        .success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .success-card {
            background: white;
            padding: 60px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
        }

        .success-card h1 {
            color: #22c55e;
            margin-bottom: 20px;
            font-size: 32px;
        }

        .success-card p {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border: 3px solid #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: #22c55e;
        }

        .success-btn {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 40px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .success-btn:hover {
            background-color: #764ba2;
        }

        .countdown {
            color: #999;
            font-size: 14px;
            margin-top: 20px;
        }

        @media (max-width: 660px) {
            .success-card {
                width: min(100%, 90vw);
                padding: 32px 20px;
            }

            .success-card h1 {
                font-size: 26px;
            }

            .success-card p {
                font-size: 15px;
            }

            .success-btn {
                width: 100%;
                padding: 14px 18px;
            }
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-card">
            <div class="checkmark">✓</div>
            <h1>Password Berhasil Di-Reset</h1>
            <p><?php echo htmlspecialchars($successMessage); ?></p>
            <a href="login.php" class="success-btn">Kembali ke Login</a>
            <p class="countdown">Anda akan diarahkan ke login dalam <span id="countdown">5</span> detik...</p>
        </div>
    </div>

    <script>
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');

        const interval = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;

            if (seconds === 0) {
                clearInterval(interval);
                window.location.href = 'login.php';
            }
        }, 1000);
    </script>
</body>

</html>
