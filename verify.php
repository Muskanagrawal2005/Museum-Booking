<?php
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE token = ? AND is_verified = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1, token = NULL WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        echo "Account verified successfully. <a href='login.php'>Login here</a>";
    } else {
        echo "Invalid or expired token.";
    }
} 

?>