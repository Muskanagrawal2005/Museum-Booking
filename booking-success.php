<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the latest booking for the user
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date DESC LIMIT 1");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    header("Location: booking-error.php?message=No booking found");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful - Heritage Museum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-[#F5F5DC] font-['Inter']">
    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="text-center mb-8">
                    <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <h2 class="text-3xl font-['SF_Pro_Display'] text-[#8B4513] mb-4">Booking Successful!</h2>
                    <p class="text-gray-600">Your museum visit has been confirmed</p>
                </div>

                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">Booking ID: <?php echo htmlspecialchars($booking['id']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center border-b border-[#DEB887] pb-2">
                        <span class="text-gray-600">Show</span>
                        <span class="font-medium"><?php echo htmlspecialchars($booking['show_name']); ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-[#DEB887] pb-2">
                        <span class="text-gray-600">Number of Tickets</span>
                        <span class="font-medium"><?php echo $booking['num_tickets']; ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-[#DEB887] pb-2">
                        <span class="text-gray-600">Show Time</span>
                        <span class="font-medium"><?php echo htmlspecialchars($booking['show_time']); ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-[#DEB887] pb-2">
                        <span class="text-gray-600">Booking Date</span>
                        <span class="font-medium"><?php echo date('F j, Y', strtotime($booking['booking_date'])); ?></span>
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <span class="text-xl font-bold text-[#8B4513]">Total Amount</span>
                        <span class="text-xl font-bold text-[#8B4513]">₹<?php echo number_format($booking['total_amount'], 2); ?></span>
                    </div>
                </div>

                <div class="mt-8 flex justify-center space-x-4">
                    <button onclick="window.print()" class="bg-[#8B4513] text-white py-2 px-6 rounded-full hover:bg-[#A0522D] transform hover:scale-105 transition-all duration-300 shadow-lg">
                        Print Ticket
                    </button>
                    <a href="index.php" class="bg-gray-200 text-gray-700 py-2 px-6 rounded-full hover:bg-gray-300 transform hover:scale-105 transition-all duration-300">
                        Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
