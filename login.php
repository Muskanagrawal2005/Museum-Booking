<?php 
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    try {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if ($username === 'admin' && $password === '123') {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin-dashboard.php');
            exit();
        }
        // Validate input
        if (empty($username) || empty($password)) {
            throw new Exception("Username and password are required");
        }

        // Check user credentials
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['logged_in'] = true;
            
            // Clear any existing error messages
            unset($_SESSION['error']);
            
            header("Location: index.php");
            exit();
        } else {
            throw new Exception("Invalid email or password");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Heritage Museum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-[#F5F5DC] font-['Inter']">
    <!-- Navbar -->
    <nav class="bg-[#8B4513] text-[#F5F5DC] py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="text-2xl font-['SF_Pro_Display'] tracking-tight">Heritage Museum</div>
            <div class="space-x-6">
                <a href="index.php" class="hover:text-[#DEB887]">Home</a>
                <a href="about.php" class="hover:text-[#DEB887]">About</a>
                <a href="exhibitions.php" class="hover:text-[#DEB887]">Exhibitions</a>
                <a href="tickets.php" class="hover:text-[#DEB887]">Tickets</a>
                <a href="contact.php" class="hover:text-[#DEB887]">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="py-16 bg-[#F5F5DC]">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto">
                <div class="vintage-card">
                    <h2 class="text-3xl font-['SF_Pro_Display'] tracking-tight text-center mb-8">Login</h2>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="" class="space-y-6">
                        <div class="mb-4">
                            <label class="block mb-2">Login as:</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="user_type" value="user" class="form-radio" checked>
                                    <span class="ml-2">User</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="user_type" value="admin" class="form-radio">
                                    <span class="ml-2">Admin</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2">Username</label>
                            <input type="text" name="username" class="w-full p-2 border rounded" placeholder="Enter your username" required>
                        </div>
                        <div>
                            <label class="block mb-2">Password</label>
                            <input type="password" name="password" class="w-full p-2 border rounded" placeholder="Enter your password" required>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remember_me" class="form-checkbox">
                                <span class="ml-2">Remember Me</span>
                            </label>
                        </div>
                        <button type="submit" name="login" class="w-full vintage-button">
                            Login
                        </button>
                    </form>
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">Don't have an account? <a href="register.php" class="text-[#8B4513] hover:text-[#A0522D]">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#8B4513] text-[#F5F5DC] py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-['SF_Pro_Display'] mb-4">Contact Us</h3>
                    <p>91 Museum Street</p>
                    <p>Udaipur, Rajasthan</p>
                    <p>Phone: (+91) 7984458050</p>
                </div>
                <div>
                    <h3 class="text-xl font-['SF_Pro_Display'] mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="hover:text-[#DEB887]">Home</a></li>
                        <li><a href="about.php" class="hover:text-[#DEB887]">About</a></li>
                        <li><a href="exhibitions.php" class="hover:text-[#DEB887]">Exhibitions</a></li>
                        <li><a href="contact.php" class="hover:text-[#DEB887]">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-['SF_Pro_Display'] mb-4">Opening Hours</h3>
                    <p>Monday - Friday: 10:00 AM - 6:00 PM</p>
                    <p>Saturday - Sunday: 11:00 AM - 5:00 PM</p>
                </div>
            </div>
            <div class="text-center mt-8 pt-8 border-t border-[#8B4513]/20">
                <p>&copy; 2025 Museum of Indian Heritage. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
    <script>
        function selectUserType(type) {
            if (type === 'user') {
                alert('User login selected');
            } else if (type === 'admin') {
                alert('Admin login selected');
            }
        }
    </script>
</body>
</html>