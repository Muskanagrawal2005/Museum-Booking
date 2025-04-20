<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password
$dbname = "museum_booking";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    // Don't expose the error details to users in production
    die("Connection failed. Please try again later.");
}
?>
