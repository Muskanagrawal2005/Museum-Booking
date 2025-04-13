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
                
                // Fetch available shows
                $stmt = $conn->prepare("SELECT id, name, description, price FROM shows");
                $stmt->execute();
                $result = $stmt->get_result();
                
                $response = "Please select a show by entering its number:\n\n";
                $i = 1;
                while ($show = $result->fetch_assoc()) {
                    $response .= "$i. {$show['name']} - \${$show['price']}\n";
                    $response .= "{$show['description']}\n\n";
                    $_SESSION['show_options'][$i] = $show['id'];
                    $i++;
                }
            } else {
                $response = "Welcome to Museum Booking System!\n";
                $response .= "Available shows:\n\n";
                
                $stmt = $conn->prepare("SELECT name, description, price FROM shows");
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($show = $result->fetch_assoc()) {
                    $response .= "{$show['name']} - \${$show['price']}\n";
                    $response .= "{$show['description']}\n\n";
                }
                
                $response .= "Type 'book' to start booking tickets.";
            }
            break;

        case 'select_show':
            if (isset($_SESSION['show_options'][$message])) {
                $_SESSION['booking_state'] = 'num_tickets';
                $_SESSION['selected_show'] = $_SESSION['show_options'][$message];
                $response = "How many tickets would you like to book?";
            } else {
                $response = "Please select a valid show number.";
            }
            break;

        case 'num_tickets':
            if (is_numeric($message) && $message > 0) {
                $_SESSION['booking_state'] = 'visitor_name';
                $_SESSION['num_tickets'] = $message;
                $response = "Please enter the visitor's name:";
            } else {
                $response = "Please enter a valid number of tickets.";
            }
            break;

        case 'visitor_name':
            if (strlen($message) > 0) {
                $_SESSION['booking_state'] = 'show_time';
                $_SESSION['visitor_name'] = $message;
                
                // Fetch available slots
                $stmt = $conn->prepare("SELECT available_slots FROM shows WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['selected_show']);
                $stmt->execute();
                $result = $stmt->get_result();
                $show = $result->fetch_assoc();
                $slots = json_decode($show['available_slots']);
                
                $response = "Please select a show time (enter the number):\n\n";
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
                $_SESSION['booking_state'] = 'mobile_number';
                $_SESSION['show_time'] = $_SESSION['time_slots'][$message - 1];
                $response = "Please enter your mobile number:";
            } else {
                $response = "Please select a valid time slot number.";
            }
            break;

        case 'mobile_number':
            if (preg_match("/^[0-9]{10}$/", $message)) {
                // Save booking to database
                $stmt = $conn->prepare("INSERT INTO bookings (user_id, show_id, num_tickets, visitor_name, show_time, mobile_number) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiisss", 
                    $userId,
                    $_SESSION['selected_show'],
                    $_SESSION['num_tickets'],
                    $_SESSION['visitor_name'],
                    $_SESSION['show_time'],
                    $message
                );
                
                if ($stmt->execute()) {
                    $response = "Booking confirmed!\n\n";
                    $response .= "Booking details:\n";
                    $response .= "Visitor: {$_SESSION['visitor_name']}\n";
                    $response .= "Show time: {$_SESSION['show_time']}\n";
                    $response .= "Number of tickets: {$_SESSION['num_tickets']}\n";
                    $response .= "Mobile: $message\n\n";
                    $response .= "Thank you for booking with us!";
                } else {
                    $response = "Error in booking. Please try again.";
                }
                
                // Reset booking state
                unset($_SESSION['booking_state']);
                unset($_SESSION['selected_show']);
                unset($_SESSION['num_tickets']);
                unset($_SESSION['visitor_name']);
                unset($_SESSION['show_time']);
                unset($_SESSION['time_slots']);
                unset($_SESSION['show_options']);
            } else {
                $response = "Please enter a valid 10-digit mobile number.";
            }
            break;
    }
    
    return $response;
}
?> 