<?php
session_start();
include 'includes/header.php';
?>

    <!-- Hero Section -->
    <section class="relative h-[80vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="images/musuem-bg.png" alt="Museum Interior" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/50"></div>
        </div>
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-5xl md:text-7xl font-['SF_Pro_Display'] mb-6 animate-fade-in">Welcome to Heritage Museum</h1>
            <p class="text-xl md:text-2xl mb-8 animate-slide-up">Discover India's Rich Cultural Heritage</p>
            <a href="exhibitions.php" class="inline-block bg-[#8B4513] text-white px-8 py-3 rounded-full hover:bg-[#A0522D] transform hover:scale-105 transition-all duration-300 shadow-lg animate-slide-up-delayed">Explore Exhibitions</a>
        </div>
    </section>

    <!-- Featured Exhibitions -->
    <section class="py-20 bg-gradient-to-b from-[#F5F5DC] to-[#FFE4B5]">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-['SF_Pro_Display'] tracking-tight text-center mb-16 text-[#8B4513]">Featured Exhibitions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl group">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        <img src="images/exhibition1.jpg" alt="Mughal Era Treasures" class="collection-image transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2 text-[#8B4513]">Mughal Era Treasures</h3>
                    <p class="text-gray-700">Explore the opulent world of Mughal art and architecture.</p>
                    <a href="exhibitions.php" class="inline-block mt-4 text-[#8B4513] hover:text-[#A0522D] transition-colors duration-300">Learn More →</a>
                </div>
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl group">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        <img src="images/exhibition2.jpg" alt="Ancient Indian Civilizations" class="collection-image transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2 text-[#8B4513]">Ancient Indian Civilizations</h3>
                    <p class="text-gray-700">Journey through time to discover India's ancient heritage.</p>
                    <a href="exhibitions.php" class="inline-block mt-4 text-[#8B4513] hover:text-[#A0522D] transition-colors duration-300">Learn More →</a>
                </div>
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl group">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        <img src="images/exhibition3.jpg" alt="Contemporary Indian Art" class="collection-image transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2 text-[#8B4513]">Temple Architecture</h3>
                    <p class="text-gray-700">Experience the vibrant world of modern Indian artists.</p>
                    <a href="exhibitions.php" class="inline-block mt-4 text-[#8B4513] hover:text-[#A0522D] transition-colors duration-300">Learn More →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="py-20 bg-gradient-to-b from-[#DEB887] to-[#D2691E]">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-['SF_Pro_Display'] tracking-tight text-center mb-16 text-white">Upcoming Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl bg-white/90">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-[#8B4513] text-white rounded-full flex items-center justify-center text-xl font-bold mr-4">30</div>
                        <div>
                            <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight text-[#8B4513]">Cultural Festival</h3>
                            <p class="text-gray-600">April 30, 2025</p>
                        </div>
                    </div>
                    <p class="text-gray-700">Join us for a day of cultural performances, workshops, and exhibitions.</p>
                 
                </div>
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl bg-white/90">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-[#8B4513] text-white rounded-full flex items-center justify-center text-xl font-bold mr-4">22</div>
                        <div>
                            <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight text-[#8B4513]">Art Workshop</h3>
                            <p class="text-gray-600">May 22, 2025</p>
                        </div>
                    </div>
                    <p class="text-gray-700">Learn traditional Indian art techniques from master artists.</p>
                  
                </div>
            </div>
        </div>
    </section>

   

    <!-- Cultural Elements -->
    <div class="fixed top-0 left-0 w-full h-2 bg-gradient-to-r from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed bottom-0 left-0 w-full h-2 bg-gradient-to-r from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed left-0 top-0 h-full w-2 bg-gradient-to-b from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed right-0 top-0 h-full w-2 bg-gradient-to-b from-[#FF9933] via-white to-[#138808]"></div>

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
            
            chatbotMessages.appendChild(messageDiv);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }

        // Add initial welcome message
        addMessage('bot', 'Welcome to Heritage Museum!\n\nAvailable exhibitions:\n\nAncient Egypt Exhibition - ₹25.00\nExplore the mysteries of ancient Egypt through artifacts and mummies\n\nModern Art Gallery - ₹20.00\nContemporary art from leading artists around the world\n\nDinosaur World - ₹30.00\nLife-size dinosaur models and fossil exhibitions\n\nType \'book\' to start booking tickets.');

        sendMessage.addEventListener('click', sendUserMessage);
        userInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendUserMessage();
            }
        });
    });
    </script>
 <script src="js/main.js"></script>
<?php include 'includes/footer.php'; ?> 