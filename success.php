<?php
session_start();
require_once 'includes/razorpay-config.php';

// Check if payment was successful
if (!isset($_SESSION['payment_success']) || $_SESSION['payment_success'] !== true) {
    header('Location: index.php');
    exit();
}

$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : '';
$payment_id = isset($_SESSION['payment_id']) ? $_SESSION['payment_id'] : '';
$amount = isset($_SESSION['amount']) ? $_SESSION['amount'] : '';

// Clear the session variables
unset($_SESSION['payment_success']);
unset($_SESSION['order_id']);
unset($_SESSION['payment_id']);
unset($_SESSION['amount']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Payment Successful!</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                        </div>
                        <h5 class="card-title">Thank you for your booking!</h5>
                        <p class="card-text">Your payment has been processed successfully.</p>
                        <div class="mt-3">
                            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
                            <p><strong>Payment ID:</strong> <?php echo htmlspecialchars($payment_id); ?></p>
                            <p><strong>Amount Paid:</strong> ₹<?php echo htmlspecialchars(number_format($amount / 100, 2)); ?></p>
                        </div>
                        <div class="mt-4">
                            <a href="home.php" class="btn btn-primary">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
