<?php
require_once 'includes/razorpay-config.php';
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

try {
    // Log the raw input
    error_log('Raw input: ' . file_get_contents('php://input'));
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Log decoded data
    error_log('Decoded data: ' . print_r($data, true));
    
    // Validate the input data
    if (!$data) {
        throw new Exception('Invalid JSON data received');
    }

    // Log each parameter
    error_log('Payment ID: ' . ($data['razorpay_payment_id'] ?? 'missing'));
    error_log('Order ID: ' . ($data['razorpay_order_id'] ?? 'missing'));
    error_log('Signature: ' . ($data['razorpay_signature'] ?? 'missing'));

    // Check each parameter individually
    if (empty($data['razorpay_payment_id'])) {
        throw new Exception('Payment ID is missing');
    }
    
    if (empty($data['razorpay_order_id'])) {
        throw new Exception('Order ID is missing');
    }
    
    if (empty($data['razorpay_signature'])) {
        throw new Exception('Signature is missing');
    }

    $api = getRazorpayInstance();
    
    $attributes = [
        'razorpay_order_id' => $data['razorpay_order_id'],
        'razorpay_payment_id' => $data['razorpay_payment_id'],
        'razorpay_signature' => $data['razorpay_signature']
    ];

    // Log verification attempt
    error_log('Attempting to verify signature with attributes: ' . print_r($attributes, true));

    try {
        // Verify the payment signature
        $api->utility->verifyPaymentSignature($attributes);
        error_log('Signature verification successful');
        
        // Start session and set payment success variables
        session_start();
        $_SESSION['payment_success'] = true;
        $_SESSION['order_id'] = $data['razorpay_order_id'];
        $_SESSION['payment_id'] = $data['razorpay_payment_id'];
        $_SESSION['amount'] = isset($data['amount']) ? $data['amount'] : '0'; // You might want to store this during order creation
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Payment verified successfully'
        ]);
    } catch (Exception $e) {
        error_log('Signature verification failed: ' . $e->getMessage());
        throw new Exception('Signature verification failed: ' . $e->getMessage());
    }

} catch (Exception $e) {
    error_log('Error in verify-payment.php: ' . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

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
    header('Location: index.php');
    exit;
}

try {
    $api = getRazorpayInstance();
    
    // Verify payment signature
    $attributes = array(
        'razorpay_signature' => $_GET['signature'],
        'razorpay_payment_id' => $_GET['payment_id'],
        'razorpay_order_id' => $_GET['order_id']
    );
    
    $api->utility->verifyPaymentSignature($attributes);
    
    // Generate unique ticket number
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
    
    // Redirect to error page
    header('Location: booking-error.php?message=' . urlencode($e->getMessage()));
    exit;
}
?>
