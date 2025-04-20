<?php
session_start();
require_once 'db.php';

// Get user ID from session
$userId = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} elseif (isset($_SESSION['user'])) {
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
    
    // Initialize booking session if not exists
    if (!isset($_SESSION['booking_state'])) {
        $_SESSION['booking_state'] = 'initial';
    }

    $response = '';
    $state = $_SESSION['booking_state'];

    switch ($state) {
        case 'initial':
            if (strtolower($message) === 'book') {
                $_SESSION['booking_state'] = 'select_show';
                $response = "Please select a show by entering its number:\n\n";
                $response .= "1. Mughal Era Treasures - ₹100\n";
                $response .= "   Explore the opulent world of Mughal art and architecture\n\n";
                $response .= "2. Ancient Indian Civilizations - ₹75\n";
                $response .= "   Journey through time to discover India's ancient heritage\n\n";
                $response .= "3. Modern Art Revolution - ₹150\n";
                $response .= "   Witness the evolution of Indian art in the modern era\n\n";
                $response .= "4. Digital Art & Technology - ₹150\n";
                $response .= "   Explore the intersection of traditional art and modern technology\n";
            } else {
                $response = "Welcome to Museum Booking System!\n";
                $response .= "Type 'book' to start booking tickets.";
            }
            break;

        case 'select_show':
            $shows = [
                1 => ['name' => 'Mughal Era Treasures', 'price' => 100.00],
                2 => ['name' => 'Ancient Indian Civilizations', 'price' => 75.00],
                3 => ['name' => 'Modern Art Revolution', 'price' => 150.00],
                4 => ['name' => 'Digital Art & Technology', 'price' => 150.00]
            ];

            if (isset($shows[$message])) {
                $show = $shows[$message];
                $_SESSION['show_id'] = $message;
                $_SESSION['show_name'] = $show['name'];
                $_SESSION['show_price'] = $show['price'];
                $_SESSION['booking_state'] = 'num_tickets';
                $response = "You selected: {$show['name']}\n";
                $response .= "Price per ticket: ₹{$show['price']}\n\n";
                $response .= "How many tickets would you like to book?";
            } else {
                $response = "Please select a valid show number (1-4).";
            }
            break;

        case 'num_tickets':
            if (is_numeric($message) && $message > 0) {
                $_SESSION['num_tickets'] = (int)$message;
                $_SESSION['booking_state'] = 'visitor_name';
                $response = "Please enter the visitor's name:";
            } else {
                $response = "Please enter a valid number of tickets.";
            }
            break;

        case 'visitor_name':
            if (!empty($message)) {
                $_SESSION['visitor_name'] = $message;
                $_SESSION['booking_state'] = 'show_time';
                $response = "Please select a time slot by entering its number:\n\n";
                $response .= "1. 10:00 AM\n";
                $response .= "2. 12:00 PM\n";
                $response .= "3. 02:00 PM\n";
                $response .= "4. 04:00 PM\n";
                $response .= "5. 06:00 PM\n";

                $_SESSION['time_slots'] = [
                    1 => '10:00 AM',
                    2 => '12:00 PM',
                    3 => '02:00 PM',
                    4 => '04:00 PM',
                    5 => '06:00 PM'
                ];
            } else {
                $response = "Please enter a valid name.";
            }
            break;

        case 'show_time':
            if (isset($_SESSION['time_slots'][$message])) {
                $_SESSION['show_time'] = $_SESSION['time_slots'][$message];
                $_SESSION['booking_state'] = 'mobile_number';
                $response = "Please enter your mobile number:";
            } else {
                $response = "Please select a valid time slot number (1-5).";
            }
            break;

        case 'mobile_number':
            if (preg_match("/^[0-9]{10}$/", $message)) {
                $_SESSION['mobile_number'] = $message;
                
                // Calculate total amount
                $_SESSION['total_amount'] = $_SESSION['show_price'] * $_SESSION['num_tickets'];
                
                // Generate booking summary and payment link
                $response = "Great! Here's your booking summary:\n\n";
                $response .= "Show: {$_SESSION['show_name']}\n";
                $response .= "Number of Tickets: {$_SESSION['num_tickets']}\n";
                $response .= "Price per Ticket: ₹{$_SESSION['show_price']}\n";
                $response .= "Total Amount: ₹{$_SESSION['total_amount']}\n";
                $response .= "Visitor Name: {$_SESSION['visitor_name']}\n";
                $response .= "Show Time: {$_SESSION['show_time']}\n";
                $response .= "Mobile: {$_SESSION['mobile_number']}\n\n";
                
                // Add payment button with proper amount
                $response .= "[[PAYMENT_BUTTON:" . $_SESSION['total_amount'] . "]]";
                
                $_SESSION['booking_state'] = 'payment_pending';
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
    }

    return $response;
}
?>
