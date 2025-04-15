<?php
require_once 'includes/razorpay-config.php';
session_start();
require_once 'includes/razorpay-config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if amount is set in session and URL
if (!isset($_SESSION['total_amount']) || !isset($_GET['amount'])) {
    header('Location: index.php');
    exit;
}

// Verify amount matches
if ($_SESSION['total_amount'] != $_GET['amount']) {
    header('Location: index.php');
    exit;
}

// Validate all required session variables
$required_vars = ['total_amount', 'show_id', 'show_name', 'num_tickets', 'visitor_name', 'show_time', 'mobile_number'];
foreach ($required_vars as $var) {
    if (!isset($_SESSION[$var])) {
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum Booking Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <div style="text-align: center; padding: 20px;">
        <h2>Museum Booking Payment</h2>
        <button id="payButton">Pay Now</button>
    <title>Payment - Museum Booking</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f2f5;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1a73e8;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #5f6368;
            margin: 10px 0 0;
        }
        .booking-details {
            background: #f8fafb;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .booking-details h2 {
            margin: 0 0 15px;
            color: #202124;
            font-size: 18px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            color: #3c4043;
        }
        .total-amount {
            text-align: center;
            font-size: 32px;
            color: #1a73e8;
            margin: 30px 0;
        }
        .pay-button {
            display: block;
            width: 100%;
            padding: 15px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .pay-button:hover {
            background: #1557b0;
        }
        .secure-badge {
            text-align: center;
            margin-top: 20px;
            color: #5f6368;
            font-size: 14px;
        }
        .secure-badge i {
            margin-right: 5px;
            color: #34a853;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Complete Your Booking</h1>
            <p>Please review your booking details before payment</p>
        </div>

        <div class="booking-details">
            <h2>Booking Summary</h2>
            <div class="detail-row">
                <span>Show</span>
                <span><?php echo htmlspecialchars($_SESSION['show_name']); ?></span>
            </div>
            <div class="detail-row">
                <span>Number of Tickets</span>
                <span><?php echo htmlspecialchars($_SESSION['num_tickets']); ?></span>
            </div>
            <div class="detail-row">
                <span>Price per Ticket</span>
                <span>₹<?php echo htmlspecialchars($_SESSION['show_price']); ?></span>
            </div>
            <div class="detail-row">
                <span>Visitor Name</span>
                <span><?php echo htmlspecialchars($_SESSION['visitor_name']); ?></span>
            </div>
            <div class="detail-row">
                <span>Show Time</span>
                <span><?php echo htmlspecialchars($_SESSION['show_time']); ?></span>
            </div>
            <div class="detail-row">
                <span>Mobile</span>
                <span><?php echo htmlspecialchars($_SESSION['mobile_number']); ?></span>
            </div>
        </div>

        <div class="total-amount">
            Total Amount: ₹<?php echo htmlspecialchars($_SESSION['total_amount']); ?>
        </div>

        <button class="pay-button" id="payButton">Proceed to Payment</button>

        <div class="secure-badge">
            <i>🔒</i> Secure Payment by Razorpay
        </div>
    </div>

    <script>
        document.getElementById('payButton').onclick = async function() {
            try {
                // First create an order
                const response = await fetch('process-payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: 1000, // Change this to your actual amount
                        currency: 'INR',
                        description: 'Museum Booking Payment'
                    })
                });
                
                const data = await response.json();
                if (data.status !== 'success') throw new Error(data.message);

                // Store order ID in a variable accessible to the handler
                const razorpayOrderId = data.order.id;
                console.log('Debug - Order created with ID:', razorpayOrderId);

                // Create order
                const response = await fetch('process-payment.php', {
                    method: 'POST'
                });
                
                const data = await response.json();
                if (data.status !== 'success') {
                    throw new Error(data.message || 'Payment initialization failed');
                }

                // Configure Razorpay
                const options = {
                    key: '<?php echo RAZORPAY_KEY_ID; ?>', 
                    amount: data.order.amount,
                    currency: data.order.currency,
                    name: 'Museum Booking',
                    description: 'Museum Entry Ticket',
                    order_id: razorpayOrderId,
                    handler: function (response) {
                        console.log('Debug - Payment completed:', response);

                        // Verify the payment
                        fetch('verify-payment.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: razorpayOrderId,
                                razorpay_signature: response.razorpay_signature
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Debug - Verification result:', data);
                            if (data.status === 'success') {
                                alert('Payment successful!');
                                window.location.href = 'success.php';
                            } else {
                                alert('Payment verification failed: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Debug - Verification error:', error);
                            alert('Payment verification failed: ' + error.message);
                        });
                    },
                    "modal": {
                        "ondismiss": function() {
                            console.log('Debug - Payment modal closed');
                        }
                    },
                    "theme": {
                        "color": "#3399cc"
                    }
                };

                console.log('Debug - Opening payment with options:', {
                    amount: options.amount,
                    currency: options.currency,
                    order_id: options.order_id
                });

                    description: '<?php echo htmlspecialchars($_SESSION['show_name']); ?> - <?php echo $_SESSION['num_tickets']; ?> ticket(s)',
                    order_id: data.order.id,
                    handler: function (response) {
                        // Redirect to verify payment
                        window.location.href = 'verify-payment.php?' + 
                            'payment_id=' + response.razorpay_payment_id + 
                            '&order_id=' + response.razorpay_order_id + 
                            '&signature=' + response.razorpay_signature;
                    },
                    prefill: {
                        name: '<?php echo addslashes($_SESSION['visitor_name']); ?>',
                        contact: '<?php echo addslashes($_SESSION['mobile_number']); ?>'
                    },
                    theme: {
                        color: '#1a73e8'
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
                
            } catch (error) {
                alert('Error: ' + error.message);
                alert('Payment initialization failed: ' + error.message);
                console.error('Error:', error);
            }
        };
    </script>
</body>
</html>
