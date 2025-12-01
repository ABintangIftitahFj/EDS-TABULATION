<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full antialiased bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin Panel - <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&family=Inter:wght@400;600;700&display=swap"
        rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Scrollbar Styles -->
    <style>
        /* Custom Scrollbar for Webkit Browsers (Chrome, Safari, Edge) */
        .overflow-x-auto::-webkit-scrollbar {
            height: 12px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
            margin: 0 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Firefox Scrollbar */
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #94a3b8 #f1f5f9;
        }

        /* Smooth scrolling */
        .overflow-x-auto {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
    </style>

    <?php echo $__env->yieldPushContent('head'); ?>
</head>

<body class="flex h-full font-sans text-black bg-[url('https://www.transparenttextures.com/patterns/graphy.png')]">

    <!-- Mobile Header -->
    <div
        class="md:hidden fixed top-0 w-full z-40 bg-england-blue border-b-4 border-england-red px-4 h-16 flex items-center justify-between shadow-lg">
        <div class="font-pixel text-2xl text-white tracking-widest">EDS ADMIN</div>
        <button onclick="toggleSidebar()" class="text-white p-2 hover:bg-white/10 rounded">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-england-blue border-r-4 border-england-red transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl md:shadow-none">
        <div class="flex items-center h-20 flex-shrink-0 px-6 bg-england-blue border-b-4 border-england-red">
            <div class="font-pixel text-3xl text-white tracking-widest drop-shadow-md">EDS ADMIN</div>
            <button onclick="toggleSidebar()" class="md:hidden ml-auto text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="flex-1 px-4 space-y-2 mt-6 overflow-y-auto">
            <a href="<?php echo e(route('admin.dashboard')); ?>"
                class="group flex items-center px-4 py-3 text-xl font-pixel rounded-lg transition-all <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-england-red text-white shadow-pixel-sm border-2 border-black' : 'text-white hover:bg-white/10 hover:translate-x-1'); ?>">
                <span class="mr-3 text-2xl">🏠</span>
                Home
            </a>
            <a href="<?php echo e(route('admin.tournaments.index')); ?>"
                class="group flex items-center px-4 py-3 text-xl font-pixel rounded-lg transition-all <?php echo e(request()->routeIs('admin.tournaments.*') ? 'bg-england-red text-white shadow-pixel-sm border-2 border-black' : 'text-white hover:bg-white/10 hover:translate-x-1'); ?>">
                <span class="mr-3 text-2xl">🏆</span>
                Tournaments
            </a>
            <a href="<?php echo e(route('admin.teams.index')); ?>"
                class="group flex items-center px-4 py-3 text-xl font-pixel rounded-lg transition-all <?php echo e(request()->routeIs('admin.teams.*') ? 'bg-england-red text-white shadow-pixel-sm border-2 border-black' : 'text-white hover:bg-white/10 hover:translate-x-1'); ?>">
                <span class="mr-3 text-2xl">👥</span>
                Teams
            </a>
            <a href="<?php echo e(route('admin.rounds.index')); ?>"
                class="group flex items-center px-4 py-3 text-xl font-pixel rounded-lg transition-all <?php echo e(request()->routeIs('admin.rounds.*') ? 'bg-england-red text-white shadow-pixel-sm border-2 border-black' : 'text-white hover:bg-white/10 hover:translate-x-1'); ?>">
                <span class="mr-3 text-2xl">🔁</span>
                Rounds
            </a>
            <a href="<?php echo e(route('admin.matches.index')); ?>"
                class="group flex items-center px-4 py-3 text-xl font-pixel rounded-lg transition-all <?php echo e(request()->routeIs('admin.matches.*') ? 'bg-england-red text-white shadow-pixel-sm border-2 border-black' : 'text-white hover:bg-white/10 hover:translate-x-1'); ?>">
                <span class="mr-3 text-2xl">⚔️</span>
                Matches
            </a>
            <a href="<?php echo e(route('admin.motions.index')); ?>"
                class="group flex items-center px-4 py-3 text-xl font-pixel rounded-lg transition-all <?php echo e(request()->routeIs('admin.motions.*') ? 'bg-england-red text-white shadow-pixel-sm border-2 border-black' : 'text-white hover:bg-white/10 hover:translate-x-1'); ?>">
                <span class="mr-3 text-2xl">💡</span>
                Motions
            </a>
            <a href="<?php echo e(route('admin.adjudicators.index')); ?>"
                class="group flex items-center px-4 py-3 text-xl font-pixel rounded-lg transition-all <?php echo e(request()->routeIs('admin.adjudicators.*') ? 'bg-england-red text-white shadow-pixel-sm border-2 border-black' : 'text-white hover:bg-white/10 hover:translate-x-1'); ?>">
                <span class="mr-3 text-2xl">⚖️</span>
                Adjudicators
            </a>
            <a href="<?php echo e(route('admin.rooms.index')); ?>"
                class="group flex items-center px-4 py-3 text-xl font-pixel rounded-lg transition-all <?php echo e(request()->routeIs('admin.rooms.*') ? 'bg-england-red text-white shadow-pixel-sm border-2 border-black' : 'text-white hover:bg-white/10 hover:translate-x-1'); ?>">
                <span class="mr-3 text-2xl">🏛️</span>
                Rooms
            </a>
        </nav>
        <div class="flex-shrink-0 flex border-t-4 border-england-red p-4 bg-england-blue">
            <div class="flex-shrink-0 w-full group block">
                <div class="flex items-center mb-4">
                    <div>
                        <div class="text-lg font-pixel text-white tracking-wide"><?php echo e(Auth::user()->name); ?></div>
                        <div class="text-xs font-mono text-soft-pink"><?php echo e(Auth::user()->email); ?></div>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full text-center px-4 py-2 text-xl font-pixel rounded border-2 border-white text-white hover:bg-white hover:text-england-blue transition-all shadow-pixel-sm">
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()"
        class="fixed inset-0 bg-black/50 z-40 hidden md:hidden backdrop-blur-sm transition-opacity"></div>

    <!-- Main Content -->
    <div class="md:pl-64 flex flex-col flex-1 min-h-screen transition-all duration-300 min-w-0">
        <main class="flex-1 pt-20 md:pt-6">
            <div class="py-6">
                <div class="max-w-full w-full mx-auto px-4 sm:px-6 md:px-8">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </main>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>

</html><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/layouts/admin.blade.php ENDPATH**/ ?>