document.addEventListener('DOMContentLoaded', function() {
    const chatbotContainer = document.createElement('div');
    chatbotContainer.className = 'chatbot-container';
    chatbotContainer.style.display = 'none';
    
    const chatbotHTML = `
        <div class="chatbot-header">
            <h3>Museum Assistant</h3>
            <button class="chatbot-close">&times;</button>
        </div>
        <div class="chatbot-messages"></div>
        <div class="chatbot-input">
            <input type="text" placeholder="Type your message...">
            <button>Send</button>
        </div>
    `;
    
    chatbotContainer.innerHTML = chatbotHTML;
    document.body.appendChild(chatbotContainer);

    const toggleButton = document.createElement('div');
    toggleButton.className = 'chatbot-toggle';
    toggleButton.innerHTML = '<i class="fas fa-comments"></i>';
    document.body.appendChild(toggleButton);

    const messagesContainer = chatbotContainer.querySelector('.chatbot-messages');
    const inputField = chatbotContainer.querySelector('input');
    const sendButton = chatbotContainer.querySelector('button');
    const closeButton = chatbotContainer.querySelector('.chatbot-close');

    // Add Font Awesome for icons
    const fontAwesome = document.createElement('link');
    fontAwesome.rel = 'stylesheet';
    fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
    document.head.appendChild(fontAwesome);

    function appendMessage(message, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
        
        if (isUser) {
            messageDiv.textContent = message;
        } else {
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
            } else if (message.includes('<div class=\'html-content\'>')) {
                // Extract the HTML content
                const htmlContent = message.split('<div class=\'html-content\'>')[1].split('</div>')[0];
                messageDiv.innerHTML = htmlContent;
            } else {
                // Regular text message with line breaks
                messageDiv.innerHTML = message.replace(/\n/g, '<br>');
            }
        }
        
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function showLoading() {
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'message bot-message';
        loadingDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Thinking...';
        loadingDiv.id = 'loading-message';
        messagesContainer.appendChild(loadingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function hideLoading() {
        const loadingMessage = document.getElementById('loading-message');
        if (loadingMessage) {
            loadingMessage.remove();
        }
    }

    async function sendMessage() {
        const message = inputField.value.trim();
        if (!message) return;

        appendMessage(message, true);
        inputField.value = '';
        showLoading();

        try {
            const response = await fetch('includes/chatbot_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `message=${encodeURIComponent(message)}`
            });

            const data = await response.text();
            hideLoading();

            try {
                const jsonData = JSON.parse(data);
                if (jsonData.type === 'html') {
                    // Create a container for the HTML content
                    const htmlContainer = document.createElement('div');
                    htmlContainer.className = 'message bot-message';
                    htmlContainer.innerHTML = jsonData.content;
                    messagesContainer.appendChild(htmlContainer);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                } else if (jsonData.type === 'payment') {
                    // Display booking summary with payment button
                    appendMessage(jsonData.message);
                } else {
                    appendMessage(data);
                }
            } catch (e) {
                appendMessage(data);
            }
        } catch (error) {
            console.error('Error:', error);
            hideLoading();
            appendMessage('Sorry, there was an error processing your request. Please try again.');
        }
    }

    // Event listeners
    toggleButton.addEventListener('click', () => {
        chatbotContainer.style.display = chatbotContainer.style.display === 'none' ? 'flex' : 'none';
    });

    closeButton.addEventListener('click', () => {
        chatbotContainer.style.display = 'none';
    });

    sendButton.addEventListener('click', sendMessage);

    inputField.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Add welcome message
    appendMessage("Welcome to Museum Booking System!\nType 'book' to start booking tickets.");
}); 