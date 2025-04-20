<?php
session_start();
include 'includes/header.php';
?>

    <!-- Current Exhibitions -->
    <section class="py-16 bg-[#F5F5DC]">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-['SF_Pro_Display'] tracking-tight text-center mb-12">Current Exhibitions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl group">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        <img src="images/exhibition1.jpg" alt="Mughal Era Treasures" class="collection-image transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2 text-[#8B4513]">Mughal Era Treasures</h3>
                    <p class="text-gray-700">Explore the opulent world of Mughal art and architecture.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-[#8B4513] font-semibold">₹100</span>
                        <a href="tickets.php?exhibition_id=1&price=100" class="bg-[#8B4513] text-white px-4 py-2 rounded-full hover:bg-[#A0522D] transition-colors duration-300">Get Info</a>
                    </div>
                </div>
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl group">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        <img src="images/exhibition2.jpg" alt="Ancient Indian Civilizations" class="collection-image transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2 text-[#8B4513]">Ancient Indian Civilizations</h3>
                    <p class="text-gray-700">Journey through time to discover India's ancient heritage.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-[#8B4513] font-semibold">₹75</span>
                        <a href="tickets.php?exhibition_id=2&price=75" class="bg-[#8B4513] text-white px-4 py-2 rounded-full hover:bg-[#A0522D] transition-colors duration-300">Get Info</a>
                    </div>
                </div>
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl group">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        <img src="images/exhibition5.jpg" alt="Modern Art Revolution" class="collection-image transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2 text-[#8B4513]">Modern Art Revolution</h3>
                    <p class="text-gray-700">Witness the evolution of Indian art in the modern era.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-[#8B4513] font-semibold">₹150</span>
                        <a href="tickets.php?exhibition_id=3&price=150" class="bg-[#8B4513] text-white px-4 py-2 rounded-full hover:bg-[#A0522D] transition-colors duration-300">Get Info</a>
                    </div>
                </div>
                <div class="vintage-card transform hover:scale-105 transition-transform duration-300 shadow-xl group">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        <img src="images/exhibition6.jpg" alt="Digital Art & Technology" class="collection-image transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2 text-[#8B4513]">Digital Art & Technology</h3>
                    <p class="text-gray-700">Explore the intersection of traditional art and modern technology.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-[#8B4513] font-semibold">₹150</span>
                        <a href="tickets.php?exhibition_id=4&price=150" class="bg-[#8B4513] text-white px-4 py-2 rounded-full hover:bg-[#A0522D] transition-colors duration-300">Get Info</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Exhibitions -->
    <section class="py-16 bg-[#DEB887]">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-['SF_Pro_Display'] tracking-tight text-center mb-12">Upcoming Exhibitions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="exhibition-card">
                    <img src="images/exhibition3.jpg" alt="Temple Architecture" class="w-full h-64 object-cover rounded-lg mb-4">
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2">Temple Architecture</h3>
                    <p class="text-gray-700 mb-4">Explore the architectural marvels of Indian temples, from Dravidian to Nagara styles.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-[#8B4513] font-semibold">Starting May 1, 2025</span>
                        <a href="tickets.php" class="vintage-button">Get Info</a>
                    </div>
                </div>
                <div class="exhibition-card">
                    <img src="images/exhibition4.jpg" alt="Indian Classical Music" class="w-full h-64 object-cover rounded-lg mb-4">
                    <h3 class="text-2xl font-['SF_Pro_Display'] tracking-tight mb-2">Indian Classical Music</h3>
                    <p class="text-gray-700 mb-4">Discover the rich heritage of Indian classical music through rare instruments and manuscripts.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-[#8B4513] font-semibold">Starting March 15, 2025</span>
                        <a href="tickets.php" class="vintage-button">Get Info</a>
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