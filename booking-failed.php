<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Failed</title>
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .error-icon {
            color: #dc3545;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #3399cc;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-icon">✕</div>
        <h1>Booking Failed</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <p>There was a problem processing your booking.</p>
        <a href="index.php" class="btn">Try Again</a>
    </div>
</body>
</html>
