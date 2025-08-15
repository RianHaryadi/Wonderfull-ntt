<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') - Wonderful NTT</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome & Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .floating {
            animation: float 5s ease-in-out infinite;
        }
        .ripple-btn {
            position: relative;
            overflow: hidden;
        }
        .ripple-effect {
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 9999px;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="font-sans bg-gray-50 antialiased overflow-x-hidden">

<!-- Navbar -->
<nav class="fixed top-0 w-full z-50 backdrop-blur-md bg-gradient-to-r from-blue-800 via-blue-600 to-yellow-400/80 shadow-lg border-b border-white/20 rounded-b-3xl transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <span class="text-3xl font-extrabold text-white drop-shadow-md tracking-wide">
                    Wonderful<span class="text-yellow-300">NTT</span>
                </span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('home') }}" class="text-white font-medium hover:text-yellow-300 px-3 py-2 rounded-lg transition hover:bg-white/10">Home</a>
                <a href="{{ route('destinations.index') }}" class="text-white font-medium hover:text-yellow-300 px-3 py-2 rounded-lg transition hover:bg-white/10">Destinations</a>
                <a href="{{ route('hotels.index') }}" class="text-white font-medium hover:text-yellow-300 px-3 py-2 rounded-lg transition hover:bg-white/10">Hotel</a>
                <a href="{{ route('paket-tours.index') }}" class="text-white font-medium hover:text-yellow-300 px-3 py-2 rounded-lg transition hover:bg-white/10">Tour</a>
                <a href="{{ route('cultures.index') }}" class="text-white font-medium hover:text-yellow-300 px-3 py-2 rounded-lg transition hover:bg-white/10">Culture</a>
                

                <!-- Cek Booking Button -->
                <a href="{{ route('booking.checkForm') }}" class="relative bg-yellow-300 text-blue-900 px-5 py-2 rounded-full shadow-md hover:bg-yellow-400 transition font-bold ripple-btn">
                    Cek Booking
                </a>
            </div>

            <!-- Mobile Toggle -->
            <div class="md:hidden">
                <button id="menu-btn" class="text-white focus:outline-none" aria-label="Toggle navigation menu">
                    <i id="menu-icon" class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-gradient-to-b from-blue-900 via-blue-700 to-yellow-300 px-4 py-4 rounded-b-3xl">
        <a href="{{ route('home') }}" class="block py-2 px-4 text-white rounded hover:bg-white/10">Home</a>
        <a href="{{ route('destinations.index') }}" class="block py-2 px-4 text-white rounded hover:bg-white/10">Destinations</a>
        <a href="{{ route('hotels.index') }}" class="block py-2 px-4 text-white rounded hover:bg-white/10">Hotel</a>
        <a href="{{ route('paket-tours.index') }}" class="block py-2 px-4 text-white rounded hover:bg-white/10">Tour</a>
        <a href="{{ route('cultures.index') }}" class="block py-2 px-4 text-white rounded hover:bg-white/10">Culture</a>
        <a href="{{ route('booking.checkForm') }}" class="block mt-4 py-2 px-4 text-blue-900 font-bold bg-yellow-300 rounded hover:bg-yellow-400 text-center shadow-md">
            Cek Booking
        </a>
    </div>
</nav>

<!-- Main Content -->
<main class="pt-15 min-h-screen">
    @yield('content')
</main>

<!-- Dark Footer -->
<footer class="bg-gray-900 text-gray-300 mt-20 pt-16 pb-10 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-12 text-center md:text-left">
            <!-- About -->
            <div>
                <h3 class="text-xl font-bold text-white mb-4">Wonderful NTT</h3>
                <p class="text-sm leading-relaxed text-gray-400">
                    Discover the charm of East Nusa Tenggara. From majestic islands to unique traditions, your unforgettable adventure starts here.
                </p>
                <div class="mt-4 flex justify-center md:justify-start space-x-3">
                    <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-xl font-bold text-white mb-4">Quick Links</h3>
                <ul class="text-sm space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-yellow-400 transition">Home</a></li>
                    <li><a href="{{ route('destinations.index') }}" class="hover:text-yellow-400 transition">Destinations</a></li>
                    <li><a href="{{ route('hotels.index') }}" class="hover:text-yellow-400 transition">Hotels</a></li>
                    <li><a href="{{ route('paket-tours.index') }}" class="hover:text-yellow-400 transition">Tours</a></li>
                    <li><a href="{{ route('cultures.index') }}" class="hover:text-yellow-400 transition">Culture</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-xl font-bold text-white mb-4">Contact Us</h3>
                <p class="text-sm text-gray-400">
                    Email: <a href="mailto:info@wonderfulntt.id" class="hover:text-yellow-400">info@wonderfulntt.id</a><br>
                    Phone: <a href="tel:+6281234567890" class="hover:text-yellow-400">+62 812 3456 7890</a><br>
                    Address: Kupang, Nusa Tenggara Timur
                </p>
            </div>
        </div>

        <!-- Bottom -->
        <div class="mt-12 border-t border-gray-700 pt-6 text-sm text-center text-gray-500">
            © {{ date('Y') }} <span class="text-white font-semibold">Wonderful NTT</span>. All rights reserved.
        </div>
    </div>
</footer>

<!-- JavaScript for Hamburger Menu Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        menuBtn.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
            const isMenuOpen = !mobileMenu.classList.contains('hidden');
            menuIcon.classList.toggle('fa-bars', !isMenuOpen);
            menuIcon.classList.toggle('fa-times', isMenuOpen);
        });
    });
</script>

</body>
</html>