<?php
session_start();
require_once 'includes/razorpay-config.php';

// Check if amount is set in session
if (!isset($_SESSION['total_amount'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    try {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('Please log in to continue');
        }

        // Check if amount exists in session
        if (!isset($_SESSION['total_amount'])) {
            throw new Exception('No amount found in session');
        }

        $api = getRazorpayInstance();

        // Create unique receipt ID
        $receipt = 'rcpt_' . time() . '_' . uniqid();
        
        $orderData = [
            'receipt'         => $receipt,
            'amount'         => $_SESSION['total_amount'] * 100, // Convert to paise
            'currency'       => 'INR',
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
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Process Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <div class="container">
        <h2>Payment Details</h2>
        <p>Total Amount: ₹<?php echo $_SESSION['total_amount']; ?></p>
        <button id="pay-button">Pay Now</button>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function() {
            fetch('process-payment.php', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    var options = {
                        "key": "<?php echo RAZORPAY_KEY_ID; ?>",
                        "amount": data.order.amount,
                        "currency": data.order.currency,
                        "name": "Museum Booking",
                        "description": "Ticket Booking Payment",
                        "order_id": data.order.id,
                        "handler": function (response) {
                            // On successful payment, redirect to verify-payment.php
                            window.location.href = 'verify-payment.php?payment_id=' + response.razorpay_payment_id + 
                                '&order_id=' + response.razorpay_order_id + 
                                '&signature=' + response.razorpay_signature;
                        },
                        "prefill": {
                            "name": "<?php echo $_SESSION['visitor_name']; ?>",
                            "contact": "<?php echo $_SESSION['mobile_number']; ?>"
                        },
                        "theme": {
                            "color": "#F37254"
                        }
                    };
                    var rzp = new Razorpay(options);
                    rzp.open();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        };
    </script>
</body>
</html>