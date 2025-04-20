<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to the correct database
$conn = new mysqli('localhost', 'root', '', 'user_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug session
if (!isset($_SESSION['admin_logged_in'])) {
    die("Session not set. Please login first.");
}

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Debug database connection
if (!isset($conn) || !$conn) {
    die("Database connection failed");
}

// Fetch bookings
$bookings_query = "SELECT * FROM bookings ORDER BY booking_date DESC";
$bookings_result = $conn->query($bookings_query);

if (!$bookings_result) {
    die("Error fetching bookings: " . $conn->error);
}

// Fetch registrations
$users_query = "SELECT id, username FROM users ORDER BY id DESC";
$users_result = $conn->query($users_query);

if (!$users_result) {
    die("Error fetching users: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Heritage Museum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-[#F5F5DC] font-['Inter']">
    <!-- Navbar -->
    <nav class="bg-[#8B4513] text-[#F5F5DC] py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="text-2xl font-['SF_Pro_Display'] tracking-tight">Admin Dashboard</div>
            <div>
                <a href="logout.php" class="hover:text-[#DEB887] transition-colors duration-300">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <!-- Bookings Table -->
        <div class="mb-12">
            <h2 class="text-3xl font-['SF_Pro_Display'] text-[#8B4513] mb-6">Recent Bookings</h2>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#8B4513] text-[#F5F5DC]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Ticket Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Show Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Visitor Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Number of Tickets</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Booking Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        if ($bookings_result->num_rows > 0) {
                            while ($booking = $bookings_result->fetch_assoc()): 
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($booking['ticket_number']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($booking['show_name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($booking['visitor_name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($booking['num_tickets']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹<?php echo number_format($booking['total_amount'], 2); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo date('M d, Y H:i', strtotime($booking['booking_date'])); ?></td>
                        </tr>
                        <?php 
                            endwhile;
                        } else {
                            echo '<tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No bookings found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Users Table -->
        <div>
            <h2 class="text-3xl font-['SF_Pro_Display'] text-[#8B4513] mb-6">User Registrations</h2>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#8B4513] text-[#F5F5DC]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Username</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        if ($users_result->num_rows > 0) {
                            while ($user = $users_result->fetch_assoc()): 
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($user['id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($user['username']); ?></td>
                        </tr>
                        <?php 
                            endwhile;
                        } else {
                            echo '<tr><td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">No users found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 