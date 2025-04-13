<?php 
session_start();
require_once 'includes/db.php';
include 'templates/header.html'; 
?>

<div class="container">
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="captcha-container">
            <img src="includes/captcha.php?v=<?php echo time(); ?>" alt="CAPTCHA" id="captcha-image">
            <button type="button" onclick="refreshCaptcha()" class="refresh-btn">↻</button>
            <input type="text" name="captcha" placeholder="Enter Captcha" required>
        </div>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<script>
function refreshCaptcha() {
    document.getElementById('captcha-image').src = 'includes/captcha.php?' + Date.now();
}
</script>

<?php include 'templates/footer.html'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];
    
    // Verify captcha
    if (!isset($_SESSION['captcha']) || strtolower($captcha) != strtolower($_SESSION['captcha'])) {
        echo "<p style='color:red;'>Invalid captcha! Please try again.</p>";
        exit();
    }
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        // Unset captcha after successful login
        unset($_SESSION['captcha']);
        header("Location: home.php");
        exit();
    } else {
        echo "Invalid login credentials.";
    }
    $stmt->close();
}
?>