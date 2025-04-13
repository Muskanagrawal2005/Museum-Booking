<?php
require_once 'includes/razorpay-config.php';
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

                const rzp = new Razorpay(options);
                rzp.open();
                
            } catch (error) {
                alert('Error: ' + error.message);
            }
        };
    </script>
</body>
</html>
