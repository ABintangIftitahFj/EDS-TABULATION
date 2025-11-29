<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('head')
</head>

<body class="flex h-full font-sans text-black">
    <!-- Sidebar -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 bg-slate-900">
        <div class="flex-1 flex flex-col min-h-0 overflow-y-auto">
            <div class="flex items-center h-16 flex-shrink-0 px-4 bg-slate-900 text-white font-bold text-xl">
                EDS Admin
            </div>
            <nav class="mt-5 flex-1 px-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white' : 'text-white hover:bg-slate-800 hover:text-white' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Home
                </a>
                <a href="{{ route('admin.tournaments.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.tournaments.*') ? 'bg-slate-800 text-white' : 'text-white hover:bg-slate-800 hover:text-white' }}">
                    🏆 Tournaments
                </a>
                <a href="{{ route('admin.teams.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.teams.*') ? 'bg-slate-800 text-white' : 'text-white hover:bg-slate-800 hover:text-white' }}">
                    👥 Teams
                </a>
                <a href="{{ route('admin.rounds.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.rounds.*') ? 'bg-slate-800 text-white' : 'text-white hover:bg-slate-800 hover:text-white' }}">
                    🔁 Rounds
                </a>
                <a href="{{ route('admin.matches.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.matches.*') ? 'bg-slate-800 text-white' : 'text-white hover:bg-slate-800 hover:text-white' }}">
                    ⚔️ Matches
                </a>
                <a href="{{ route('admin.motions.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.motions.*') ? 'bg-slate-800 text-white' : 'text-white hover:bg-slate-800 hover:text-white' }}">
                    💡 Motions
                </a>
                <a href="{{ route('admin.adjudicators.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.adjudicators.*') ? 'bg-slate-800 text-white' : 'text-white hover:bg-slate-800 hover:text-white' }}">
                    ⚖️ Adjudicators
                </a>
                <a href="{{ route('admin.rooms.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.rooms.*') ? 'bg-slate-800 text-white' : 'text-white hover:bg-slate-800 hover:text-white' }}">
                    🏛️ Rooms
                </a>
            </nav>
            <div class="flex-shrink-0 flex border-t border-slate-800 p-4">
                <div class="flex-shrink-0 w-full group block">
                    <div class="flex items-center">
                        <div>
                            <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs font-medium text-white">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-slate-800 hover:text-white">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="md:pl-64 flex flex-col flex-1">
        <main class="flex-1">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    @stack('scripts')
</body>

</html>
