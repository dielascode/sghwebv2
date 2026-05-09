<?php
session_start();
include 'config/connection.php';

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['otp']) || !isset($_SESSION['data_register'])) {
    header("Location: register.php");
    exit;
}

function generateID($conn) {
    $query = mysqli_query($conn, "SELECT id FROM users ORDER BY id DESC LIMIT 1");

    if (mysqli_num_rows($query) == 0) {
        return "USR001";
    }

    $data = mysqli_fetch_assoc($query);
    $number = (int) substr($data['id'], 3);
    $number++;

    return "USR" . str_pad($number, 3, "0", STR_PAD_LEFT);
}

if (isset($_POST['verify'])) {

    $otp_input = $_POST['otp'] ?? '';

    if (strlen($otp_input) != 5) {
        echo "<script>alert('OTP harus 5 digit');</script>";
    }

    elseif (time() > $_SESSION['otp_expired']) {
        session_destroy();
        echo "<script>alert('OTP kadaluarsa'); window.location='register.php';</script>";
        exit;
    }

    elseif ($otp_input == $_SESSION['otp']) {

        $data = $_SESSION['data_register'];
        $id = generateID($conn);

        $query = "INSERT INTO users 
        (id, nama, email, username, password, nomor_telepon, role) 
        VALUES 
        ('$id', '{$data['nama']}', '{$data['email']}', '{$data['email']}', '{$data['password']}', '{$data['nomor_telepon']}', 'customer')";

        if (mysqli_query($conn, $query)) {
            session_destroy();
            header("Location: login.php");
            exit;
        } else {
            echo "Error DB: " . mysqli_error($conn);
        }

    } else {
        echo "<script>alert('OTP salah');</script>";
    }
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