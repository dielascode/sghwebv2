<?php
session_start();
include 'logic/class/handleOtp.php';

if (!isset($_SESSION['otp']) || !isset($_SESSION['data_register'])) {
    header("Location: register.php");
    exit;
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

    <form method="POST" id="otpForm">
        <div class="otp-input">
            <input type="text" maxlength="1" class="otp-box">
            <input type="text" maxlength="1" class="otp-box">
            <input type="text" maxlength="1" class="otp-box">
            <input type="text" maxlength="1" class="otp-box">
            <input type="text" maxlength="1" class="otp-box">
        </div>

        <input type="hidden" name="otp" id="otp-value">

        <button type="submit" name="verify" class="btn">Verifikasi</button>
    </form>
</div>

<script>
const inputs = document.querySelectorAll(".otp-box");
const hiddenInput = document.getElementById("otp-value");
const form = document.getElementById("otpForm");

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