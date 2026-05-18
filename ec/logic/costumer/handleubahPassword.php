<?php

session_start();
require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /sghwebv2/ec/index.php?page=password');
    exit();
}

if (!isset($_SESSION['id'])) {
    header('Location: /sghwebv2/ec/index.php');
    exit();
}

$userId          = $_SESSION['id'];
$oldPassword     = trim($_POST['old_password'] ?? '');
$newPassword     = trim($_POST['new_password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');

if ($oldPassword === '' || $newPassword === '' || $confirmPassword === '') {
    $_SESSION['error'] = 'Semua field harus diisi.';
    header('Location: /sghwebv2/ec/index.php?page=password');
    exit();
}

if ($newPassword !== $confirmPassword) {
    $_SESSION['error'] = 'Password baru dan konfirmasi tidak cocok.';
    header('Location: /sghwebv2/ec/index.php?page=password');
    exit();
}

if (strlen($newPassword) < 8) {
    $_SESSION['error'] = 'Password baru minimal 8 karakter.';
    header('Location: /sghwebv2/ec/index.php?page=password');
    exit();
}

$stmt = $conn->prepare('SELECT password FROM users WHERE id = ? LIMIT 1');
if (!$stmt) {
    error_log('Prepare SELECT password failed: ' . $conn->error);
    $_SESSION['error'] = 'Terjadi masalah saat memproses permintaan.';
    header('Location: ../../index.php');
    exit();
}

$stmt->bind_param('s', $userId);
if (!$stmt->execute()) {
    error_log('Execute SELECT password failed: ' . $stmt->error);
    $_SESSION['error'] = 'Terjadi masalah saat memproses permintaan.';
    header('Location: ../../index.php');
    exit();
}

$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$user || !password_verify($oldPassword, $user['password'])) {
    $_SESSION['error'] = 'Password lama tidak sesuai.';
    header('Location: /sghwebv2/ec/index.php?page=password');
    exit();
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$stmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
if (!$stmt) {
    error_log('Prepare UPDATE password failed: ' . $conn->error);
    $_SESSION['error'] = 'Terjadi masalah saat menyimpan password.';
    header('Location: ../../index.php');
    exit();
}

$stmt->bind_param('ss', $hashedPassword, $userId);
if (!$stmt->execute()) {
    error_log('Execute UPDATE password failed: ' . $stmt->error);
    $_SESSION['error'] = 'Terjadi masalah saat menyimpan password.';
    header('Location: ../../index.php');
    exit();
}

if ($stmt->affected_rows === 0) {
    error_log('Password update did not affect any rows for user id: ' . $userId);
    $_SESSION['error'] = 'Password tidak berubah. Coba lagi.';
    $stmt->close();
    header('Location: ../../index.php');
    exit();
}

$stmt->close();

$_SESSION['success'] = 'Password berhasil diperbarui.';
header('Location: /sghwebv2/ec/index.php?page=password');
exit();