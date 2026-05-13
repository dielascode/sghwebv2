<?php
session_start();
include 'logic/class/handleOtp.php';

if (!isset($_SESSION['otp']) || !isset($_SESSION['data_register'])) {
    header("Location: register.php");
    exit;
}

$remaining_time = $_SESSION['otp_expired'] - time();
if ($remaining_time <= 0) {
    $expired = true;
} else {
    $expired = false;
}

if (isset($_POST['verify'])) {
    $otpHandler = new OtpHandler();
    $otpHandler->handleOtpVerification($_POST['otp'] ?? '');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Autentikasi OTP</title>
    <link rel="stylesheet" href="style/costumer/otpRegistStyles.css">
</head>
<body>

<div class="container">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR2gxESykRn4UL_cMBIFuufnAjtzjJRAiS9fw&s" alt="OTP">

    <h2>Autentikasi kode OTP</h2>
    <p>Masukkan 5 digit kode yang dikirim ke:</p>

    <div class="email">
        <?php echo $_SESSION['data_register']['email']; ?>
    </div>

    <div id="countdown" class="countdown">Waktu tersisa: <span id="timer"></span></div>
    <div id="expired-message" class="expired-message" style="display: none;">OTP telah hangus. Silakan daftar ulang.</div>

    <form method="POST" id="otpForm">
        <div class="otp-input">
            <input type="text" maxlength="1" class="otp-box" <?php if ($expired) echo 'disabled'; ?>>
            <input type="text" maxlength="1" class="otp-box" <?php if ($expired) echo 'disabled'; ?>>
            <input type="text" maxlength="1" class="otp-box" <?php if ($expired) echo 'disabled'; ?>>
            <input type="text" maxlength="1" class="otp-box" <?php if ($expired) echo 'disabled'; ?>>
            <input type="text" maxlength="1" class="otp-box" <?php if ($expired) echo 'disabled'; ?>>
        </div>

        <input type="hidden" name="otp" id="otp-value">

        <button type="submit" name="verify" class="btn" <?php if ($expired) echo 'disabled'; ?>>Verifikasi</button>
    </form>
</div>

<script>
const inputs = document.querySelectorAll(".otp-box");
const hiddenInput = document.getElementById("otp-value");
const form = document.getElementById("otpForm");
const timerElement = document.getElementById("timer");
const countdownElement = document.getElementById("countdown");
const expiredMessage = document.getElementById("expired-message");

let remainingTime = <?php echo $remaining_time; ?>;
let expired = <?php echo $expired ? 'true' : 'false'; ?>;

if (expired) {
    showExpired();
} else {
    startCountdown();
}

function startCountdown() {
    const interval = setInterval(() => {
        const minutes = Math.floor(remainingTime / 60);
        const seconds = remainingTime % 60;
        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        remainingTime--;
        
        if (remainingTime < 0) {
            clearInterval(interval);
            showExpired();
        }
    }, 1000);
}

function showExpired() {
    countdownElement.style.display = 'none';
    expiredMessage.style.display = 'block';
    inputs.forEach(input => input.disabled = true);
    form.querySelector('button').disabled = true;
}

// input handling
inputs.forEach((input, index) => {

    input.addEventListener("input", () => {
        input.value = input.value.replace(/[^0-9]/g, "");

        if (input.value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }

        updateOTP();
    });

    input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !input.value && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

// gabungkan OTP
function updateOTP() {
    let otp = "";
    inputs.forEach(i => otp += i.value);
    hiddenInput.value = otp;
}

// validasi submit
form.addEventListener("submit", function(e) {
    if (hiddenInput.value.length !== 5) {
        e.preventDefault();
        alert("Masukkan 5 digit OTP!");
    }
});
</script>

</body>
</html>