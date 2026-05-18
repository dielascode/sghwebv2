<?php

session_name('sghwebv2_session');
                              session_start();
include __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->conn;

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? "";
    $password = $_POST['new_password'] ?? "";
    $confirm_password = $_POST['confirm_password'] ?? "";

    if (empty($token) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Semua field wajib diisi.";
        header("Location: ../../resetPassword.php?token=" . urlencode($token));
        exit();
    }

    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password minimal 8 karakter.";
        header("Location: ../../resetPassword.php?token=" . urlencode($token));
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Kata sandi tidak cocok.";
        header("Location: ../../resetPassword.php?token=" . urlencode($token));
        exit();
    }

    try {
        $stmt = $conn->prepare("SELECT id, reset_expires FROM users WHERE reset_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && strtotime($user["reset_expires"]) > time()) {
            // hash new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // update password and clear token
            $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
            $update->bind_param("ss", $hashedPassword, $user['id']);
            $update->execute();

            $_SESSION['success'] = "Kata sandi telah berhasil direset. Anda sekarang dapat masuk.";
            header("Location: ../../login.php");
            exit();
        } else {
            $_SESSION['error'] = "Tautan pengaturan ulang tidak valid atau telah kedaluwarsa.";
            header("Location: ../../resetPassword.php?token=" . urlencode($token));
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Ada yang tidak beres: " . $e->getMessage();
        header("Location: ../../resetPassword.php?token=" . urlencode($token));
        exit();
    }
} else {
    header("Location: ../../login.php");
    exit();
}
