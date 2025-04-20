<?php
session_start();
require_once 'includes/razorpay-config.php';
require_once 'includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if payment details are present
if (!isset($_GET['payment_id']) || !isset($_GET['order_id']) || !isset($_GET['signature'])) {
    header('Location: booking-failed.php?error=' . urlencode('Payment verification failed - missing parameters'));
    exit;
}

try {
    $api = getRazorpayInstance();
    
    // Fetch payment details from Razorpay
    $payment = $api->payment->fetch($_GET['payment_id']);
    
    // Check payment status
    if ($payment->status !== 'captured') {
        throw new Exception('Payment was not successful. Status: ' . $payment->status);
    }
    
    // Verify payment signature
    $attributes = array(
        'razorpay_signature' => $_GET['signature'],
        'razorpay_payment_id' => $_GET['payment_id'],
        'razorpay_order_id' => $_GET['order_id']
    );
    
    $api->utility->verifyPaymentSignature($attributes);
    
    // Only generate ticket and save booking if payment is successful
    $ticketNumber = 'TKT' . strtoupper(uniqid());
    
    // Save booking details to database
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, show_id, show_name, num_tickets, total_amount, visitor_name, show_time, mobile_number, payment_id, ticket_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }
    
    $stmt->bind_param("iisidsssss", 
        $_SESSION['user_id'],
        $_SESSION['show_id'],
        $_SESSION['show_name'],
        $_SESSION['num_tickets'],
        $_SESSION['total_amount'],
        $_SESSION['visitor_name'],
        $_SESSION['show_time'],
        $_SESSION['mobile_number'],
        $_GET['payment_id'],
        $ticketNumber
    );
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to save booking: " . $stmt->error);
    }
    
    // Store ticket number in session for success page
    $_SESSION['ticket_number'] = $ticketNumber;
    
    // Clear booking session variables
    $booking_vars = ['show_id', 'show_name', 'show_price', 'num_tickets', 'visitor_name', 'show_time', 'mobile_number', 'total_amount', 'booking_state'];
    foreach ($booking_vars as $var) {
        unset($_SESSION[$var]);
    }
    
    // Redirect to success page
    header('Location: booking-success.php');
    exit;
    
} catch (Exception $e) {
    // Log error for debugging
    error_log("Payment verification failed: " . $e->getMessage());
    
    // Clear booking session variables on failure
    $booking_vars = ['show_id', 'show_name', 'show_price', 'num_tickets', 'visitor_name', 'show_time', 'mobile_number', 'total_amount', 'booking_state'];
    foreach ($booking_vars as $var) {
        unset($_SESSION[$var]);
    }
    
    // Redirect to error page with appropriate message
    header('Location: booking-failed.php?error=' . urlencode('Booking could not be completed: Payment verification failed'));
    exit;
}
?>