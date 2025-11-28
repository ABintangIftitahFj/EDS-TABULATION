<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EDS UPI')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-slate-900">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-slate-900">EDS UPI</a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/"
                        class="text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">Home</a>
                    <a href="/tournaments"
                        class="text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">Tournaments</a>
                    <a href="/articles"
                        class="text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">News</a>
                    <a href="/about"
                        class="text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">About</a>
                    @guest
                        <a href="/login"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">Login</a>
                        <a href="/register"
                            class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors">Register</a>
                    @else
                        <a href="/admin/dashboard"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">Admin</a>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button" class="text-slate-700 hover:text-slate-900" onclick="toggleMobileMenu()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200">
            <div class="px-4 py-4 space-y-2">
                <a href="/"
                    class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100 rounded-md">Home</a>
                <a href="/tournaments"
                    class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100 rounded-md">Tournaments</a>
                <a href="/articles"
                    class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100 rounded-md">News</a>
                <a href="/about"
                    class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100 rounded-md">About</a>
                @guest
                    <a href="/login"
                        class="block px-3 py-2 text-base font-medium text-indigo-600 hover:bg-slate-100 rounded-md">Login</a>
                    <a href="/register"
                        class="block px-3 py-2 text-base font-medium text-indigo-600 hover:bg-slate-100 rounded-md">Register</a>
                @else
                    <a href="/admin/dashboard"
                        class="block px-3 py-2 text-base font-medium text-indigo-600 hover:bg-slate-100 rounded-md">Admin
                        Dashboard</a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Column -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-bold mb-4">EDS UPI</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        The official debate society of Universitas Pendidikan Indonesia.
                        Fostering excellence in argumentation and critical thinking since 2009.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-semibold mb-4 uppercase tracking-wider text-slate-300">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/tournaments"
                                class="text-sm text-slate-400 hover:text-white transition-colors">Tournaments</a></li>
                        <li><a href="/articles"
                                class="text-sm text-slate-400 hover:text-white transition-colors">News</a></li>
                        <li><a href="/about" class="text-sm text-slate-400 hover:text-white transition-colors">About
                                Us</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-sm font-semibold mb-4 uppercase tracking-wider text-slate-300">Contact</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li>UPI Bandung</li>
                        <li>Gedung Geget Winda</li>
                        <li>085624705616</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-800 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} English Debate Society UPI. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>

</html>