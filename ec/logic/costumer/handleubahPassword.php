<?php

session_start();
require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit();
}

if (!isset($_SESSION['id'])) {
    header('Location: ../../index.php');
    exit();
}

$userId = $_SESSION['id'];
$oldPassword = trim($_POST['old_password'] ?? '');
$newPassword = trim($_POST['new_password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');

if ($oldPassword === '' || $newPassword === '' || $confirmPassword === '') {
    $_SESSION['error'] = 'Semua field harus diisi.';
    header('Location: ../../index.php');
    exit();
}

if ($newPassword !== $confirmPassword) {
    $_SESSION['error'] = 'Password baru dan konfirmasi tidak cocok.';
    header('Location: ../../index.php');
    exit();
}

if (strlen($newPassword) < 8) {
    $_SESSION['error'] = 'Password baru minimal 8 karakter.';
    header('Location: ../../index.php');
    exit();
}

$stmt = $conn->prepare('SELECT password FROM users WHERE id = ? LIMIT 1');
$stmt->bind_param('s', $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($oldPassword, $user['password'])) {
    $_SESSION['error'] = 'Password lama tidak sesuai.';
    header('Location: ../../index.php');
    exit();
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$stmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
$stmt->bind_param('ss', $hashedPassword, $userId);
$stmt->execute();
$stmt->close();

$_SESSION['success'] = 'Password berhasil diperbarui.';
header('Location: ../../index.php');
exit();
