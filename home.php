<?php 
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'templates/header.html'; 
?>

<!-- Navigation Bar -->
<nav class="navbar">
    <div class="nav-brand">Dashboard</div>
    <ul class="nav-links">
        <li><a href="home.php" class="active">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="chat.php">Chat</a></li>
        <li><a href="logout.php?logout=true" class="logout-link">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <div class="welcome-section">
        <h2>Hi, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
        <p>Welcome to your dashboard</p>
    </div>
</div>

<!-- Chatbot Button -->
<div class="chatbot-button" id="chatbotButton">
    <i class="fas fa-comments"></i>
</div>

<!-- Chatbot Container -->
<div class="chatbot-container" id="chatbotContainer">
    <div class="chatbot-header">
        <h3>Chat Assistant</h3>
        <button class="close-btn" id="closeChatbot">&times;</button>
    </div>
    <div class="chatbot-messages" id="chatbotMessages">
        <!-- Messages will be added here -->
    </div>
    <div class="chatbot-input">
        <input type="text" id="userInput" placeholder="Type your message...">
        <button id="sendMessage">Send</button>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Add JavaScript for chatbot functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotButton = document.getElementById('chatbotButton');
    const chatbotContainer = document.getElementById('chatbotContainer');
    const closeChatbot = document.getElementById('closeChatbot');
    const userInput = document.getElementById('userInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatbotMessages = document.getElementById('chatbotMessages');

    // Toggle chatbot
    chatbotButton.addEventListener('click', function() {
        chatbotContainer.classList.toggle('active');
    });

    // Close chatbot
    closeChatbot.addEventListener('click', function() {
        chatbotContainer.classList.remove('active');
    });

    // Send message
    function sendUserMessage() {
        const message = userInput.value.trim();
        if (message) {
            // Add user message
            addMessage('user', message);
            userInput.value = '';
            
            // Create form data
            const formData = new FormData();
            formData.append('message', message);
            
            // Send message to server
            fetch('includes/chatbot_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(response => {
                if (response.trim()) {
                    addMessage('bot', response);
                } else {
                    addMessage('bot', 'Sorry, I could not process your request.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                addMessage('bot', 'Sorry, there was an error processing your request.');
            });
        }
    }

    // Add message to chat
    function addMessage(sender, message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        // Sanitize and format the message
        const formattedMessage = message
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\n/g, '<br>');
        
        messageDiv.innerHTML = formattedMessage;
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    // Add initial welcome message
    addMessage('bot', 'Welcome to Museum Booking System!\nAvailable shows:\n\nAncient Egypt Exhibition - $25.00\nExplore the mysteries of ancient Egypt through artifacts and mummies\n\nModern Art Gallery - $20.00\nContemporary art from leading artists around the world\n\nDinosaur World - $30.00\nLife-size dinosaur models and fossil exhibitions\n\nType \'book\' to start booking tickets.');

    sendMessage.addEventListener('click', sendUserMessage);
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendUserMessage();
        }
    });
});
</script>

<?php 
include 'templates/footer.html';
$conn->close();
?>