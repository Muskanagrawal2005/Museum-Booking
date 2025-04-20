<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Composer's autoloader
require 'vendor/autoload.php';

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

// Debug session
if (!isset($_SESSION)) {
    die("Session not started");
}

include 'includes/db-connect.php';

// Debug database connection
if (!isset($conn) || !$conn) {
    die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    // Validate input
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: contact.php");
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: contact.php");
        exit();
    }

    try {
        $mail = new PHPMailer(true);
        
        // Enable debugging
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function($str, $level) {
            error_log("PHPMailer Debug: $str");
        };

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = "smtp.gmail.com";
        $mail->SMTPAuth   = true;
        $mail->Username   = "shivangishreya958@gmail.com";
        $mail->Password   = "icmu abzc gyno ibid";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Additional SMTP Options
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Set timeout
        $mail->Timeout = 60; // 60 seconds

        // Test SMTP connection
        if (!$mail->smtpConnect()) {
            throw new Exception("SMTP connection failed");
        }

        // ===== 1. Email to Shivangi =====
        $mail->setFrom("shivangishreya958@gmail.com", "Heritage Museum");
        $mail->addAddress("shivangishreya958@gmail.com", "Shivangi Shreya");
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body = "
            <h3>New Contact Message</h3>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Subject:</strong> {$subject}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";
        $mail->AltBody = strip_tags($message);
        $mail->send();

        // ===== 2. Confirmation Email to User =====
        $mail->clearAddresses();
        $mail->clearReplyTos();

        $mail->addAddress($email, $name);
        $mail->Subject = "Thank you for contacting Heritage Museum";
        $mail->Body = "
            <p>Dear {$name},</p>
            <p>Thank you for reaching out to us. We have received your message and will get back to you shortly.</p>
            <p><strong>Your Message:</strong><br>{$message}</p>
            <br>
            <p>Best regards,<br>Heritage Museum Team</p>
        ";
        $mail->AltBody = "Thank you for contacting Heritage Museum. We received your message.";
        $mail->send();

        // Insert into database
        try {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Thank you for your message! We will get back to you soon.";
            } else {
                throw new Exception("Database error: " . $stmt->error);
            }
            
            $stmt->close();
        } catch (Exception $e) {
            $_SESSION['error'] = "Error saving your message. Please try again later.";
            error_log("Database Error: " . $e->getMessage());
        }

    } catch (Exception $e) {
        $_SESSION['error'] = "Error sending email. Please try again later.";
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }

    $conn->close();
    
    // Store success message in session and redirect back to contact page
    $_SESSION['contact_success'] = true;
    header("Location: contact.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request method";
    header("Location: contact.php");
    exit();
}
?> 