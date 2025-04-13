<?php
require_once 'includes/razorpay-config.php';
header('Content-Type: application/json');

try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['amount']) || !isset($data['currency'])) {
        throw new Exception('Amount and currency are required');
    }

    $api = getRazorpayInstance();

    // Create unique receipt ID
    $receipt = 'rcpt_' . time() . '_' . uniqid();
    
    $orderData = [
        'receipt'         => $receipt,
        'amount'         => $data['amount'] * 100, // Convert to paise
        'currency'       => $data['currency'],
        'payment_capture' => 1 // Auto capture
    ];

    // Create order
    $order = $api->order->create($orderData);

    if (!$order || !isset($order->id)) {
        throw new Exception('Failed to create order');
    }

    // Return success response with order details
    echo json_encode([
        'status' => 'success',
        'order' => [
            'id' => $order->id,
            'amount' => $order->amount,
            'currency' => $order->currency
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
