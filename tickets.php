<?php
session_start();
include 'includes/header.php';
?>

    <!-- Hero Section -->
    <section class="py-20 relative" style="background-image: url('images/musuem-bg.png'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center text-white">
                <h1 class="text-5xl font-['SF_Pro_Display'] tracking-tight mb-6 animate-fade-in">Current Exhibitions</h1>
                <p class="text-xl mb-8 animate-slide-up">Explore our fascinating exhibitions showcasing India's rich cultural heritage.</p>
                <div class="flex justify-center space-x-4">
                    <img src="images/collection1.jpg" alt="Collection 1" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg animate-slide-up" style="animation-delay: 0s;">
                    <img src="images/collection2.jpg" alt="Collection 2" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg animate-slide-up" style="animation-delay: 0.5s;">
                    <img src="images/collection3.jpg" alt="Collection 3" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg animate-slide-up" style="animation-delay: 1s;">
                </div>
            </div>
        </div>
    </section>

    <!-- Exhibitions Section -->
    <section class="py-16 bg-[#F5F5DC]">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-['SF_Pro_Display'] tracking-tight text-center mb-12">Featured Exhibitions</h2>
            
            <!-- Mughal Era Treasures -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <div class="vintage-card p-6 transform transition-all duration-500 hover:scale-105 hover:shadow-xl animate-slide-up">
                    <div class="relative mb-4 overflow-hidden rounded-lg">
                        <img src="images/exhibition1.jpg" alt="Mughal Era Treasures" class="w-full h-48 object-cover transition-transform duration-700 hover:scale-110">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                            <h3 class="text-xl font-['SF_Pro_Display'] tracking-tight text-white">Mughal Era Treasures</h3>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[#8B4513] font-semibold">Duration: June - August 2023</span>
                            <span class="text-[#8B4513] font-semibold">Location: Main Gallery</span>
                        </div>
                        <p class="text-gray-700">Experience the grandeur of the Mughal Empire through our carefully curated collection of artifacts, jewelry, and artwork. This exhibition showcases the rich cultural heritage and artistic achievements of one of India's most influential dynasties.</p>
                    </div>
                </div>

                <!-- Ancient Indian Civilizations -->
                <div class="vintage-card p-6 transform transition-all duration-500 hover:scale-105 hover:shadow-xl animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="relative mb-4 overflow-hidden rounded-lg">
                        <img src="images/exhibition2.jpg" alt="Ancient Indian Civilizations" class="w-full h-48 object-cover transition-transform duration-700 hover:scale-110">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                            <h3 class="text-xl font-['SF_Pro_Display'] tracking-tight text-white">Ancient Indian Civilizations</h3>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[#8B4513] font-semibold">Duration: Permanent</span>
                            <span class="text-[#8B4513] font-semibold">Location: East Wing</span>
                        </div>
                        <p class="text-gray-700">Discover the rich history of ancient Indian civilizations through archaeological findings and historical artifacts. This exhibition takes you on a journey through time, exploring the cultural and technological advancements of India's earliest societies.</p>
                    </div>
                </div>

                <!-- Temple Architecture -->
                <div class="vintage-card p-6 transform transition-all duration-500 hover:scale-105 hover:shadow-xl animate-slide-up" style="animation-delay: 0.4s;">
                    <div class="relative mb-4 overflow-hidden rounded-lg">
                        <img src="images/exhibition3.jpg" alt="Temple Architecture" class="w-full h-48 object-cover transition-transform duration-700 hover:scale-110">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                            <h3 class="text-xl font-['SF_Pro_Display'] tracking-tight text-white">Temple Architecture</h3>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[#8B4513] font-semibold">Duration: September - November 2023</span>
                            <span class="text-[#8B4513] font-semibold">Location: West Wing</span>
                        </div>
                        <p class="text-gray-700">Explore the architectural marvels of India's ancient temples. This exhibition showcases the intricate carvings, structural innovations, and spiritual significance of temple architecture across different regions and time periods.</p>
                    </div>
                </div>

                <!-- Contemporary Indian Art -->
                <div class="vintage-card p-6 transform transition-all duration-500 hover:scale-105 hover:shadow-xl animate-slide-up" style="animation-delay: 0.6s;">
                    <div class="relative mb-4 overflow-hidden rounded-lg">
                        <img src="images/exhibition4.jpg" alt="Contemporary Indian Art" class="w-full h-48 object-cover transition-transform duration-700 hover:scale-110">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                            <h3 class="text-xl font-['SF_Pro_Display'] tracking-tight text-white">Contemporary Indian Art</h3>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[#8B4513] font-semibold">Duration: December - February 2024</span>
                            <span class="text-[#8B4513] font-semibold">Location: Modern Art Gallery</span>
                        </div>
                        <p class="text-gray-700">Experience the vibrant world of modern Indian artists. This exhibition features contemporary artworks that reflect India's cultural diversity and the evolving nature of artistic expression in the modern era.</p>
                    </div>
                </div>
            </div>

            <!-- Visiting Information Card -->
            <div class="max-w-4xl mx-auto mt-16">
                <div class="vintage-card p-6 relative overflow-hidden animate-slide-up" style="animation-delay: 0.6s;">
                    <div class="absolute top-0 right-0 w-1/3 h-full opacity-10">
                        <img src="images/paper-texture.png" alt="Texture" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-6">Visiting Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xl font-semibold mb-4">Opening Hours</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center animate-slide-up" style="animation-delay: 0.7s;"><span class="font-bold mr-2">Monday - Friday:</span> 9:00 AM - 5:00 PM</li>
                                <li class="flex items-center animate-slide-up" style="animation-delay: 0.8s;"><span class="font-bold mr-2">Saturday - Sunday:</span> 10:00 AM - 6:00 PM</li>
                                <li class="flex items-center animate-slide-up" style="animation-delay: 0.9s;"><span class="font-bold mr-2">Last Entry:</span> 30 minutes before closing</li>
                                <li class="flex items-center animate-slide-up" style="animation-delay: 1s;"><span class="font-bold mr-2">Closed:</span> Major holidays</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold mb-4">Important Notes</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center animate-slide-up" style="animation-delay: 0.7s;"><span class="text-green-600 mr-2">✓</span> Children under 5 enter free</li>
                                <li class="flex items-center animate-slide-up" style="animation-delay: 0.8s;"><span class="text-green-600 mr-2">✓</span> Student discounts available (with ID)</li>
                                <li class="flex items-center animate-slide-up" style="animation-delay: 0.9s;"><span class="text-green-600 mr-2">✓</span> Group bookings welcome</li>
                                <li class="flex items-center animate-slide-up" style="animation-delay: 1s;"><span class="text-green-600 mr-2">✓</span> Wheelchair accessible</li>
                            </ul>
                        </div>
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

    <script src="js/main.js"></script>
<?php include 'includes/footer.php'; ?> 