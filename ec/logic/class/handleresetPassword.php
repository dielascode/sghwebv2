<?php

session_start();
require_once __DIR__ . '/../../config/connection.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? "";
    $password = $_POST['password'] ?? "";
    $confirm_password = $_POST['confirm_password'] ?? "";


    if (empty($token) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "All field are required.";
        header("Location: ../../../resetPassword.php?token=" . urlencode($token));
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../../../resetPassword.php?token=" . urlencode($token));
        exit();
    }

    try {


        $stmt = $pdo->prepare("SELECT id, reset_expires FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user && strtotime($user["reset_expires"]) > time()) {

            // hash new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // update password and clear token
            $update = $pdo->prepare("UPDATE users SET password = ?, reset_token = null, reset_expires = null WHERE id = ?");
            $update->execute([$hashedPassword, $user['id']]);

            echo $_SESSION['success'] = "Password has been reset successfully. you can now login.";
            header("Location: ../../../login.php");
            exit();
        } else {
            $_SESSION['error'] = "Reset link is invalid or expired.";
            header("Location: ../../../resetPassword.php?token=" . urlencode($token));
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Something went wrong.";
        header("Location: ../../../resetPassword.php?token=" . urlencode($token));
        exit();
    }
} else {
    header("Location: ../../../login.php");
    exit();
}
