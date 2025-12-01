<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'EDS UPI'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        /* Pixel Cat Animation */
        .pixel-cat-container {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            z-index: 40;
            pointer-events: none;
            overflow: hidden;
        }

        .pixel-cat {
            position: absolute;
            bottom: 0;
            width: 64px;
            height: 64px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="%23000" d="M20 18h2v2h-2zm-4 0h2v2h-2zm-2 2h2v2h-2zm-2 2h2v2h-2zm-2 0h2v2h-2zm18-6h2v2h-2zm2 2h2v2h-2zm0 2h-2v2h2zm-2 2h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2zm-2 0h-2v2h2z"/><path fill="%23FFB7D5" d="M11 20h2v2h-2zm4 0h2v2h-2z"/><path fill="%23000" d="M9 16h2v2H9zm4 0h2v2h-2zm10 0h2v2h-2zm-4 0h2v2h-2z"/></svg>');
            background-size: contain;
            background-repeat: no-repeat;
            animation: walk 20s linear infinite;
        }

        /* Simple CSS Cat Shape (Fallback/Alternative) */
        .cat-walking {
            position: absolute;
            bottom: 0;
            width: 40px;
            height: 25px;
            background: #000;
            box-shadow: 
                5px -5px 0 0 #000,
                10px -5px 0 0 #000,
                15px -10px 0 0 #000,
                20px -10px 0 0 #000,
                25px -5px 0 0 #000,
                30px 0 0 0 #000,
                35px 0 0 0 #000,
                5px 5px 0 0 #000,
                10px 5px 0 0 #000,
                15px 5px 0 0 #000,
                20px 5px 0 0 #000,
                25px 5px 0 0 #000,
                30px 5px 0 0 #000,
                35px 5px 0 0 #000,
                5px 10px 0 0 #000,
                35px 10px 0 0 #000;
            animation: walk 15s linear infinite;
        }
        
        .cat-head {
            position: absolute;
            top: -15px;
            right: -5px;
            width: 15px;
            height: 15px;
            background: #000;
            box-shadow: 
                5px -5px 0 0 #000,
                -5px 0 0 0 #000;
        }
        
        .cat-tail {
            position: absolute;
            top: -10px;
            left: -5px;
            width: 5px;
            height: 20px;
            background: #000;
            transform: rotate(-45deg);
            transform-origin: bottom right;
            animation: tail-wag 1s ease-in-out infinite alternate;
        }

        @keyframes walk {
            0% { left: -10%; transform: scaleX(1); }
            49% { left: 110%; transform: scaleX(1); }
            50% { left: 110%; transform: scaleX(-1); } /* Flip */
            100% { left: -10%; transform: scaleX(-1); }
        }
        
        @keyframes tail-wag {
            0% { transform: rotate(-45deg); }
            100% { transform: rotate(-25deg); }
        }

        /* Navbar Transition */
        #main-navbar {
            transition: all 0.3s ease-in-out;
        }
        
        .navbar-hidden {
            transform: translateY(-100%);
            opacity: 0;
        }
        
        .navbar-scrolled {
            background-color: rgba(0, 36, 125, 0.85) !important; /* England Blue with opacity */
            backdrop-filter: blur(8px);
            border-bottom-width: 2px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
            height: 4rem !important; /* Smaller height */
        }
        
        .navbar-scrolled .logo-container {
            width: 2.5rem !important;
            height: 2.5rem !important;
            border-width: 1px !important;
        }
        
        .navbar-scrolled .logo-text {
            font-size: 1.5rem !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 selection:bg-soft-pink selection:text-england-blue">
    <!-- Navigation -->
    <nav id="main-navbar" class="sticky top-0 z-50 bg-england-blue border-b-4 border-england-red shadow-lg transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 transition-all duration-300" id="navbar-content">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="logo-container w-12 h-12 bg-white border-2 border-black shadow-pixel-sm flex items-center justify-center transform rotate-3 hover:rotate-0 transition-all overflow-hidden">
                        <img src="<?php echo e(asset('images/logo.jpeg')); ?>" alt="EDS UPI Logo" class="w-full h-full object-cover">
                    </div>
                    <a href="/" class="logo-text text-3xl font-pixel text-white tracking-widest hover:text-soft-pink transition-colors drop-shadow-md">
                        EDS UPI
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/"
                        class="font-pixel text-xl text-white hover:text-soft-pink hover:underline decoration-4 decoration-soft-pink underline-offset-4 transition-all">HOME</a>
                    <a href="/tournaments"
                        class="font-pixel text-xl text-white hover:text-soft-pink hover:underline decoration-4 decoration-soft-pink underline-offset-4 transition-all">TOURNAMENTS</a>
                    <a href="/articles"
                        class="font-pixel text-xl text-white hover:text-soft-pink hover:underline decoration-4 decoration-soft-pink underline-offset-4 transition-all">NEWS</a>
                    <a href="/about"
                        class="font-pixel text-xl text-white hover:text-soft-pink hover:underline decoration-4 decoration-soft-pink underline-offset-4 transition-all">ABOUT</a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button" class="text-white hover:text-soft-pink p-2 border-2 border-white rounded shadow-pixel-sm active:shadow-none active:translate-y-1 transition-all" onclick="toggleMobileMenu()">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t-4 border-england-red bg-england-blue">
            <div class="px-4 py-4 space-y-2">
                <a href="/"
                    class="block px-3 py-2 font-pixel text-xl text-white hover:bg-white/10 rounded-md">HOME</a>
                <a href="/tournaments"
                    class="block px-3 py-2 font-pixel text-xl text-white hover:bg-white/10 rounded-md">TOURNAMENTS</a>
                <a href="/articles"
                    class="block px-3 py-2 font-pixel text-xl text-white hover:bg-white/10 rounded-md">NEWS</a>
                <a href="/about"
                    class="block px-3 py-2 font-pixel text-xl text-white hover:bg-white/10 rounded-md">ABOUT</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="bg-[url('https://www.transparenttextures.com/patterns/graphy.png')] pb-20">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Pixel Cat Animation Container -->
    <div class="pixel-cat-container">
        <div class="cat-walking">
            <div class="cat-head"></div>
            <div class="cat-tail"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white mt-24 border-t-4 border-england-red">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Column -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="font-pixel text-2xl text-soft-pink mb-4">EDS UPI</h3>
                    <p class="text-slate-300 text-sm leading-relaxed font-sans">
                        The official debate society of Universitas Pendidikan Indonesia.
                        Fostering excellence in argumentation and critical thinking since 2009.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-pixel text-lg text-white mb-4 uppercase tracking-wider border-b-2 border-england-red inline-block">Quick Links</h4>
                    <ul class="space-y-2 font-pixel text-lg">
                        <li><a href="/tournaments"
                                class="text-slate-300 hover:text-soft-pink transition-colors">Tournaments</a></li>
                        <li><a href="/articles"
                                class="text-slate-300 hover:text-soft-pink transition-colors">News</a></li>
                        <li><a href="/about" class="text-slate-300 hover:text-soft-pink transition-colors">About
                                Us</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-pixel text-lg text-white mb-4 uppercase tracking-wider border-b-2 border-england-red inline-block">Contact</h4>
                    <ul class="space-y-2 text-sm text-slate-300 font-sans">
                        <li class="flex items-center gap-2">🏫 UPI Bandung</li>
                        <li class="flex items-center gap-2">📍 Gedung Geget Winda</li>
                        <li class="flex items-center gap-2">📞 085624705616</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-800 text-center text-sm text-slate-400 font-pixel tracking-wide">
                &copy; <?php echo e(date('Y')); ?> ENGLISH DEBATE SOCIETY UPI. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Navbar Scroll Effect
        let lastScrollTop = 0;
        const navbar = document.getElementById('main-navbar');
        const navbarContent = document.getElementById('navbar-content');
        let isScrolling;

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Clear timeout if scrolling continues
            window.clearTimeout(isScrolling);

            if (scrollTop > 50) {
                // Scrolling Down or Active
                navbar.classList.add('navbar-scrolled');
                
                // Hide navbar while scrolling down rapidly
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                     navbar.classList.add('navbar-hidden');
                } else {
                     navbar.classList.remove('navbar-hidden');
                }
            } else {
                // At Top
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.remove('navbar-hidden');
            }
            
            lastScrollTop = scrollTop;

            // Set a timeout to run after scrolling ends
            isScrolling = setTimeout(function() {
                // When scrolling stops, show navbar
                navbar.classList.remove('navbar-hidden');
            }, 150); // 150ms delay to detect "stop"
        });
    </script>
</body>

</html><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\layouts\public.blade.php ENDPATH**/ ?>