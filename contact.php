<?php
session_start();
/*if (isset($_SESSION['contact_success'])) {
    echo '<div class="alert alert-success" style="position: fixed; top: 20px; right: 20px; z-index: 1000; padding: 15px; background-color: #4CAF50; color: white; border-radius: 5px;">
        Thank you for your message! We will get back to you soon.
    </div>';
    unset($_SESSION['contact_success']);
}*/
include 'includes/header.php';
?>

    <!-- Contact Information -->
    <section class="py-12 md:py-16 bg-[#F5F5DC]">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-['SF_Pro_Display'] tracking-tight text-center mb-8 md:mb-12">Get in Touch</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:gap-8">
                <div class="vintage-card p-4 md:p-6">
                    <h3 class="text-xl md:text-2xl font-['SF_Pro_Display'] tracking-tight mb-3 md:mb-4">Contact Information</h3>
                    <div class="space-y-3 md:space-y-4">
                        <p class="flex items-center text-sm md:text-base">
                            <svg class="w-5 h-5 md:w-6 md:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            91 Museum Street, Udaipur, Rajasthan
                        </p>
                        <p class="flex items-center text-sm md:text-base">
                            <svg class="w-5 h-5 md:w-6 md:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            (+91) 7984458050
                        </p>
                        <p class="flex items-center text-sm md:text-base">
                            <svg class="w-5 h-5 md:w-6 md:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            info@heritagemuseum.com
                        </p>
                    </div>
                </div>
                <div class="vintage-card p-4 md:p-6">
                    <h3 class="text-xl md:text-2xl font-['SF_Pro_Display'] tracking-tight mb-3 md:mb-4">Opening Hours</h3>
                    <div class="space-y-2 text-sm md:text-base">
                        <p>Monday - Friday: 9:00 AM - 5:00 PM</p>
                        <p>Saturday - Sunday: 10:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="py-12 md:py-16 bg-[#DEB887]">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <div class="vintage-card p-4 md:p-6">
                    <h3 class="text-xl md:text-2xl font-['SF_Pro_Display'] tracking-tight text-center mb-6">Send Us a Message</h3>
                    
                    <!-- Display success or error messages -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    
                    <form action="process-contact.php" method="POST" class="space-y-4 md:space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                            <div>
                                <label for="name" class="block text-sm md:text-base font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" required class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8B4513] focus:border-transparent">
                            </div>
                            <div>
                                <label for="email" class="block text-sm md:text-base font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" required class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8B4513] focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm md:text-base font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" id="subject" name="subject" required class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8B4513] focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm md:text-base font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="message" name="message" rows="4" required class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8B4513] focus:border-transparent"></textarea>
                        </div>
                        
                        <div class="pt-2 md:pt-4">
                            <button type="submit" class="w-full bg-[#8B4513] text-white py-2 md:py-3 px-4 md:px-6 rounded-md hover:bg-[#A0522D] transition-colors duration-300 text-base md:text-lg font-medium">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Cultural Elements -->
    <div class="fixed top-0 left-0 w-full h-2 bg-gradient-to-r from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed bottom-0 left-0 w-full h-2 bg-gradient-to-r from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed left-0 top-0 h-full w-2 bg-gradient-to-b from-[#FF9933] via-white to-[#138808]"></div>
    <div class="fixed right-0 top-0 h-full w-2 bg-gradient-to-b from-[#FF9933] via-white to-[#138808]"></div>

<?php include 'includes/footer.php'; ?>