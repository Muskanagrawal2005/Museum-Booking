<?php 
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'db.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $username = $_POST['username'];
        
        $password = $_POST['password'];
       

        $captcha = $_POST['captcha'];

        // Verify captcha
        if (!isset($_SESSION['captcha']) || strtolower($captcha) != strtolower($_SESSION['captcha'])) {
            echo "<script>showAlert('Invalid captcha! Please try again.', 'error');</script>";
            exit();
        }

        // Check if email already exists
        $check_stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if ($check_stmt->num_rows > 0) {
            $_SESSION['error'] = "Username already exists. Please use another username.";
            header("Location: register.php");
            exit();
        }
        $check_stmt->close();

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Get the newly created user's ID
            $user_id = $stmt->insert_id;
            
            // Set session variables
            $_SESSION['user'] = $username;
            $_SESSION['user_id'] = $user_id;
            
            // $_SESSION['first_name'] = $first_name;
            // $_SESSION['last_name'] = $last_name;

            unset($_SESSION['captcha']);
            echo "<script>
                showAlert('Registration successful! You can now login.', 'success');
                setTimeout(() => window.location.href = 'login.php', 2000);
            </script>";
            
            // Clear any error messages
            unset($_SESSION['error']);
            
            // Redirect to index page
            header("Location: index.php");
            exit();
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = "Error in registration: " . $e->getMessage();
        header("Location: register.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Heritage Museum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-group { margin-bottom: 1rem; }
        .input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-group i {
    position: absolute;
    left: 1rem;
    color: #8B4513;
}

.input-group input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.input-group input:focus {
    border-color: #8B4513;
    box-shadow: 0 0 0 2px rgba(139, 69, 19, 0.1);
    outline: none;
}

.captcha-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 1rem;
    border-radius: 8px;
}

.captcha-group img {
    height: 60px;
    width: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.refresh-btn {
    background: #8B4513;
    border: none;
    color: white;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.refresh-btn:hover {
    background: #A0522D;
    transform: rotate(180deg);
}

.refresh-btn i {
    font-size: 1.2rem;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

    </style>
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

    <!-- Sign Up Section -->
    <section class="py-16 bg-[#F5F5DC]">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto">
                <div class="vintage-card">
                    <h2 class="text-3xl font-['SF_Pro_Display'] tracking-tight text-center mb-8">Create Account</h2>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="" class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2">Username</label>
                                <input type="text" name="username" class="w-full p-2 border rounded" placeholder="User name" required>
                            </div>
                            <!-- <div>
                                <label class="block mb-2">Last Name</label>
                                <input type="text" name="last_name" class="w-full p-2 border rounded" placeholder="Last name" required>
                            </div> -->
                        </div>
                        <!-- <div>
                            <label class="block mb-2">Email</label>
                            <input type="email" name="email" class="w-full p-2 border rounded" placeholder="Enter your email" required>
                        </div> -->
                        <div>
                            <label class="block mb-2">Password</label>
                            <input type="password" name="password" class="w-full p-2 border rounded" placeholder="Create a password" required>
                        </div>
                        <!-- <div>
                            <label class="block mb-2">Confirm Password</label>
                            <input type="password" name="confirm_password" class="w-full p-2 border rounded" placeholder="Confirm your password" required>
                        </div> -->

                        <div class="form-group">
                <div class="captcha-group">
                    <img src="includes/captcha.php?v=<?php echo time(); ?>" alt="CAPTCHA" id="captcha-image">
                    <button type="button" onclick="refreshCaptcha()" class="refresh-btn">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="input-group">
                    <i class="fas fa-shield-alt"></i>
                    <input type="text" id="captcha" name="captcha" placeholder="Enter Code" required>
                </div>
            </div>



                        <div class="flex items-center">
                            <input type="checkbox" class="mr-2" required>
                            <label class="text-sm text-gray-600">I agree to the <a href="#" class="text-[#8B4513] hover:text-[#A0522D]">Terms of Service</a> and <a href="#" class="text-[#8B4513] hover:text-[#A0522D]">Privacy Policy</a></label>
                        </div>
                        <button type="submit" class="w-full vintage-button">
                            Create Account
                        </button>
                    </form>
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">Already have an account? <a href="login.php" class="text-[#8B4513] hover:text-[#A0522D]">Sign in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cultural Elements -->
    <div class="fixed top-0 left-0 w-full h-2 bg-gradient-to-r from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed bottom-0 left-0 w-full h-2 bg-gradient-to-r from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed left-0 top-0 h-full w-2 bg-gradient-to-b from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed right-0 top-0 h-full w-2 bg-gradient-to-b from-[#FF9933] via-white to-[#138808]"></div>

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
    <script>
function refreshCaptcha() {
    document.getElementById('captcha-image').src = 'includes/captcha.php?' + Date.now();
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <div class="alert-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
    `;
    document.body.appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => alertDiv.remove(), 5000);
}
</script>
    <script src="js/main.js"></script>
</body>
</html>