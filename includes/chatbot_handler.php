<?php
session_start();
require_once 'db.php';

// Get user ID from session
$userId = null;
if (isset($_SESSION['user'])) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        $userId = $user['id'];
        $_SESSION['user_id'] = $userId;
    }
}

// Handle incoming POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];

    if ($userId) {
        $response = handleChatbotMessage($message, $userId);
        echo $response;
    } else {
        echo "Please log in to use the booking system.";
    }
    exit;
}

function handleChatbotMessage($message, $userId) {
    global $conn;

    if (!isset($_SESSION['booking_state'])) {
        $_SESSION['booking_state'] = 'initial';
    }

    $response = '';
    $state = $_SESSION['booking_state'];

    switch ($state) {
        case 'initial':
            if (strtolower($message) === 'book') {
                $_SESSION['booking_state'] = 'select_show';

                $stmt = $conn->prepare("SELECT id, name, description, price FROM shows");
                $stmt->execute();
                $result = $stmt->get_result();

                $response = "Please select a show by entering its number:\n\n";
                $i = 1;
                while ($show = $result->fetch_assoc()) {
                    $response .= "$i. {$show['name']} - ₹{$show['price']}\n";
                    $response .= "{$show['description']}\n\n";
                    $_SESSION['show_options'][$i] = $show['id'];
                    $i++;
                }
            } else {
                $response = "Welcome to Museum Booking System!\nType 'book' to start booking tickets.";
            }
            break;

        case 'select_show':
            if (isset($_SESSION['show_options'][$message])) {
                $_SESSION['booking_state'] = 'num_tickets';
                $_SESSION['selected_show'] = $_SESSION['show_options'][$message];

                // Fetch selected show info
                $stmt = $conn->prepare("SELECT name, price FROM shows WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['selected_show']);
                $stmt->execute();
                $result = $stmt->get_result();
                $show = $result->fetch_assoc();

                $_SESSION['show_name'] = $show['name'];
                $_SESSION['show_price'] = $show['price'];

                $response = "You selected: {$show['name']}\n";
                $response .= "Price per ticket: ₹{$show['price']}\n\n";
                $response .= "How many tickets would you like to book?";
            } else {
                $response = "Please select a valid show number.";
            }
            break;

        case 'num_tickets':
            if (is_numeric($message) && $message > 0) {
                $_SESSION['booking_state'] = 'visitor_name';
                $_SESSION['num_tickets'] = (int)$message;
                $response = "Please enter the visitor's name:";
            } else {
                $response = "Please enter a valid number of tickets.";
            }
            break;

        case 'visitor_name':
            if (!empty($message)) {
                $_SESSION['visitor_name'] = $message;
                $_SESSION['booking_state'] = 'show_time';

                $stmt = $conn->prepare("SELECT available_slots FROM shows WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['selected_show']);
                $stmt->execute();
                $result = $stmt->get_result();
                $show = $result->fetch_assoc();
                $slots = json_decode($show['available_slots'], true);

                $response = "Please select a time slot by entering its number:\n\n";
                foreach ($slots as $i => $slot) {
                    $response .= ($i + 1) . ". $slot\n";
                }
                $_SESSION['time_slots'] = $slots;
            } else {
                $response = "Please enter a valid name.";
            }
            break;

        case 'show_time':
            if (is_numeric($message) && isset($_SESSION['time_slots'][$message - 1])) {
                $_SESSION['show_time'] = $_SESSION['time_slots'][$message - 1];
                $_SESSION['booking_state'] = 'mobile_number';
                $response = "Please enter your mobile number:";
            } else {
                $response = "Please select a valid time slot number.";
            }
            break;

        case 'mobile_number':
            if (preg_match("/^[0-9]{10}$/", $message)) {
                $_SESSION['mobile_number'] = $message;

                $stmt = $conn->prepare("INSERT INTO bookings (user_id, show_id, num_tickets, visitor_name, show_time, mobile_number) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiisss",
                    $userId,
                    $_SESSION['selected_show'],
                    $_SESSION['num_tickets'],
                    $_SESSION['visitor_name'],
                    $_SESSION['show_time'],
                    $_SESSION['mobile_number']
                );

                if ($stmt->execute()) {
                    $_SESSION['total_amount'] = $_SESSION['show_price'] * $_SESSION['num_tickets'];

                    $response = "Great! Here's your booking summary:\n\n";
                    $response .= "Show: {$_SESSION['show_name']}\n";
                    $response .= "Number of Tickets: {$_SESSION['num_tickets']}\n";
                    $response .= "Price per Ticket: ₹{$_SESSION['show_price']}\n";
                    $response .= "Total Amount: ₹{$_SESSION['total_amount']}\n";
                    $response .= "Visitor Name: {$_SESSION['visitor_name']}\n";
                    $response .= "Show Time: {$_SESSION['show_time']}\n";
                    $response .= "Mobile: {$_SESSION['mobile_number']}\n\n";
                    $response .= "Click here to make payment: ";
                    $response .= "<a href='/Museum-Booking-backend/payment.php?amount={$_SESSION['total_amount']}' class='payment-link' style='color: #4CAF50; text-decoration: none; font-weight: bold;'>➤ Pay ₹{$_SESSION['total_amount']}</a>";

                    $_SESSION['booking_state'] = 'payment_pending';
                } else {
                    $response = "Error in booking. Please try again.";
                }
            } else {
                $response = "Please enter a valid 10-digit mobile number.";
            }
            break;

        case 'payment_pending':
            if (strtolower($message) === 'book') {
                $_SESSION['booking_state'] = 'initial';
                return handleChatbotMessage('book', $userId);
            } else {
                $response = "Please click the 'Proceed to Payment' button above to complete your booking.\n";
                $response .= "Or type 'book' to start a new booking.";
            }
            break;

        default:
            $_SESSION['booking_state'] = 'initial';
            $response = "Welcome to Museum Booking System!\nType 'book' to start booking tickets.";
            break;
    }

    return $response;
}
?>
