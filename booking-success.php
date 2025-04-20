<?php
session_start();

// Check if ticket number exists
if (!isset($_SESSION['ticket_number'])) {
    header('Location: index.php');
    exit;
}

$ticketNumber = $_SESSION['ticket_number'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful - Museum Booking</title>
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
            text-align: center;
        }
        .success-icon {
            font-size: 48px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .ticket-number {
            font-size: 24px;
            color: #1a73e8;
            padding: 15px;
            background: #f8fafb;
            border-radius: 8px;
            margin: 20px 0;
            font-family: monospace;
        }
        .message {
            color: #5f6368;
            line-height: 1.6;
            margin: 20px 0;
        }
        .home-button {
            display: inline-block;
            padding: 12px 24px;
            background: #1a73e8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .home-button:hover {
            background: #1557b0;
        }
        .print-button {
            display: inline-block;
            padding: 12px 24px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 10px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .print-button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✓</div>
        <h1>Booking Successful!</h1>
        <p class="message">Your museum visit has been booked successfully.</p>
        
        <div class="ticket-number">
            Ticket #: <?php echo htmlspecialchars($ticketNumber); ?>
        </div>
        
        <p class="message">
            Please save this ticket number. You'll need to show it at the museum entrance.<br>
            We've also sent a confirmation email with these details.
        </p>
        
        <button onclick="window.print()" class="print-button">Print Ticket</button>
        <a href="home.php" class="home-button">Back to Home</a>
    </div>
</body>
</html><?php
// Clear the ticket number from session after showing
unset($_SESSION['ticket_number']);
?>
