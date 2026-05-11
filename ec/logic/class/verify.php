<?php

require_once  __DIR__ . '/../../config/connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE verification_token = ? AND verified = 0");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $update = $pdo->prepare("UPDATE users SET verified = 1, verification_token = NULL WHERE id = ?");
        $update->execute([$user['id']]);
        echo "Your Account has been verified! you can now <a href='./login.html'>login</a>.";
    } else {
        echo "Invalid or expired verification link.";
    }
    
} else {
    echo "No token provided.";
}
?>