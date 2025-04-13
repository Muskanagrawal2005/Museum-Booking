<?php 
session_start();
require_once 'includes/db.php';
include 'templates/header.html'; 
?>

<div class="container">
    <h2>Register</h2>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="captcha-container">
            <img src="includes/captcha.php?v=<?php echo time(); ?>" alt="CAPTCHA" id="captcha-image">
            <button type="button" onclick="refreshCaptcha()" class="refresh-btn">↻</button>
            <input type="text" name="captcha" placeholder="Enter Captcha" required>
        </div>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<script>
function refreshCaptcha() {
    document.getElementById('captcha-image').src = 'includes/captcha.php?' + Date.now();
}
</script>

<?php include 'templates/footer.html'; ?>

<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $captcha = $_POST['captcha'];

    // Verify captcha
    if (!isset($_SESSION['captcha']) || strtolower($captcha) != strtolower($_SESSION['captcha'])) {
        echo "<p style='color:red;'>Invalid captcha! Please try again.</p>";
        exit();
    }

    // Check if username already exists
    $check_stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        echo "<p style='color:red;'>Username already exists. Please choose another.</p>";
        $check_stmt->close();
    } else {
        $check_stmt->close();
        
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            // Unset captcha after successful registration
            unset($_SESSION['captcha']);
            echo "<p style='color:green;'>Registration successful! You can now login.</p>";
        } else {
            echo "Error in registration.";
        }
        $stmt->close();
    }
}
?>

