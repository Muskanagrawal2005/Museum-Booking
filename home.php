<?php 
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php'; 
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-[#8B4513] mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
        <p class="text-gray-700">Explore our amazing exhibitions and book your visit today</p>
    </div>
</div>

<!-- Chatbot Button -->
<div class="chatbot-button" id="chatbotButton">
    <i class="fas fa-comments"></i>
</div>

<!-- Chatbot Container -->
<div class="chatbot-container" id="chatbotContainer">
    <div class="chatbot-header">
        <h3>Museum Assistant</h3>
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
<link rel="stylesheet" href="styles/style.css">

<!-- Add JavaScript for chatbot functionality -->

<script>
// Add this before your existing script
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for welcome section
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    // Observe welcome section
    const welcomeSection = document.querySelector('.welcome-section');
    observer.observe(welcomeSection);

    // Add parallax effect to welcome decoration
    document.addEventListener('mousemove', (e) => {
        const decoration = document.querySelector('.welcome-decoration');
        const x = (window.innerWidth - e.pageX) / 100;
        const y = (window.innerHeight - e.pageY) / 100;
        
        decoration.style.transform = `translate(${x}px, ${y}px)`;
    });
});

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
    function sendUserMessage(messageOverride = null) {
        const message = messageOverride || userInput.value.trim();
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
                    // Process the response
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
        
        if (sender === 'bot') {
            // Check if the message contains the payment button marker
            if (message.includes('[[PAYMENT_BUTTON')) {
                // Split the message at the marker
                const parts = message.split('[[PAYMENT_BUTTON');
                
                // Add the text part
                const textPart = parts[0]
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/\n/g, '<br>');
                
                messageDiv.innerHTML = textPart;
                
                // Extract amount from the marker
                const amountMatch = message.match(/\[\[PAYMENT_BUTTON:(\d+(\.\d+)?)\]\]/);
                const amount = amountMatch ? amountMatch[1] : '0';
                
                // Create and add the payment button
                const paymentButtonContainer = document.createElement('div');
                paymentButtonContainer.className = 'payment-button-container';
                paymentButtonContainer.style.textAlign = 'center';
                paymentButtonContainer.style.marginTop = '20px';
                
                const paymentButton = document.createElement('a');
                paymentButton.href = 'payment.php?amount=' + amount;
                paymentButton.className = 'payment-button';
                paymentButton.target = '_blank';
                paymentButton.style.display = 'inline-block';
                paymentButton.style.padding = '10px 20px';
                paymentButton.style.backgroundColor = '#007bff';
                paymentButton.style.color = 'white';
                paymentButton.style.textDecoration = 'none';
                paymentButton.style.borderRadius = '5px';
                paymentButton.style.fontSize = '16px';
                
                // Add Font Awesome icon if available
                if (typeof FontAwesome !== 'undefined') {
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-credit-card';
                    icon.style.marginRight = '5px';
                    paymentButton.appendChild(icon);
                }
                
                // Add text
                const buttonText = document.createTextNode(' Pay ₹' + amount);
                paymentButton.appendChild(buttonText);
                
                paymentButtonContainer.appendChild(paymentButton);
                messageDiv.appendChild(paymentButtonContainer);
            } else {
                // Sanitize and format the message
                const formattedMessage = message
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/\n/g, '<br>');
                
                messageDiv.innerHTML = formattedMessage;
            }
        } else {
            // User message
            messageDiv.textContent = message;
        }
        
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    // Add initial welcome message
    addMessage('bot', 'Welcome to Museum Booking System!\nAvailable shows:\n\nAncient Egypt Exhibition - $25.00\nExplore the mysteries of ancient Egypt through artifacts and mummies\n\nModern Art Gallery - $20.00\nContemporary art from leading artists around the world\n\nDinosaur World - $30.00\nLife-size dinosaur models and fossil exhibitions\n\nType \'book\' to start booking tickets.');

    sendMessage.addEventListener('click', () => sendUserMessage());
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendUserMessage();
        }
    });

    function openBooking(exhibition) {
        addMessage('user', 'book ' + exhibition);
        sendUserMessage('book ' + exhibition);
    }
});
</script>

<?php 
include 'includes/footer.php';
$conn->close();
?>