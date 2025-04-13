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
?>
