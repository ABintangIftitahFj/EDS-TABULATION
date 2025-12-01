@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span
                        class="inline-flex items-center px-3 py-1 text-sm font-pixel text-england-blue bg-soft-pink border-2 border-black shadow-pixel-sm transform -rotate-2">
                        {{ $tournament->format ?? 'AP' }}
                    </span>
                    <span
                        class="text-lg font-pixel text-slate-600 bg-white px-2 border-2 border-slate-300">{{ $tournament->year ?? date('Y') }}</span>
                    <span id="current-time" class="text-sm font-pixel text-england-blue bg-white px-2 border-2 border-slate-300 ml-2 py-1"></span>
                </div>
                <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm mt-2">
                    🏆 {{ $tournament->name ?? 'Tournament Name' }}
                </h1>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b-4 border-slate-200 mb-8 overflow-x-auto pb-1">
            <nav class="-mb-1 flex space-x-8 min-w-max" aria-label="Tabs">
                <a href="/tournaments" class="pixel-tab text-slate-600 hover:text-black">
                    ← ALL TOURNAMENTS
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}" class="pixel-tab pixel-tab-active">
                    🏠 OVERVIEW
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/motions" class="pixel-tab text-slate-600 hover:text-black">
                    💡 MOTIONS
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/standings"
                    class="pixel-tab text-slate-600 hover:text-black">
                    🏆 STANDINGS
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/matches" class="pixel-tab text-slate-600 hover:text-black">
                    ⚔️ MATCHES & DRAW
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/results" class="pixel-tab text-slate-600 hover:text-black">
                    📊 RESULTS
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/speakers"
                    class="pixel-tab text-slate-600 hover:text-black">
                    🎤 SPEAKERS
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/adjudicators"
                    class="pixel-tab text-slate-600 hover:text-black">
                    ⚖️ ADJUDICATORS
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/participants"
                    class="pixel-tab text-slate-600 hover:text-black">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        <!-- Statistics Cards (Horizontal) -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
            {{-- Teams Card --}}
            <a href="{{ route('tournaments.standings', $tournament->id) }}"
                class="pixel-card p-4 md:p-6 bg-white relative overflow-hidden group hover:-translate-y-1 transition-transform duration-200 cursor-pointer block">
                <div class="absolute top-0 right-0 p-2 md:p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="h-16 w-16 md:h-24 md:w-24 text-england-blue" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="flex items-center relative z-10">
                    <div class="flex-shrink-0 bg-soft-pink border-2 border-black shadow-pixel-sm p-2 md:p-3">
                        <svg class="h-6 w-6 md:h-8 md:w-8 text-england-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <p class="text-xs md:text-sm font-pixel text-slate-500 uppercase tracking-widest">Teams</p>
                        <p class="text-2xl md:text-4xl font-pixel text-england-blue">{{ $tournament->teams->count() ?? 0 }}</p>
                    </div>
                </div>
            </a>

            {{-- Adjudicators Card --}}
            <a href="{{ route('tournaments.adjudicators', $tournament->id) }}"
                class="pixel-card p-4 md:p-6 bg-white relative overflow-hidden group hover:-translate-y-1 transition-transform duration-200 cursor-pointer block">
                <div class="absolute top-0 right-0 p-2 md:p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="h-16 w-16 md:h-24 md:w-24 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="flex items-center relative z-10">
                    <div class="flex-shrink-0 bg-purple-600 border-2 border-black shadow-pixel-sm p-2 md:p-3">
                        <svg class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <p class="text-xs md:text-sm font-pixel text-slate-500 uppercase tracking-widest">Adjudicators</p>
                        <p class="text-2xl md:text-4xl font-pixel text-purple-600">{{ $tournament->adjudicators->count() ?? 0 }}</p>
                    </div>
                </div>
            </a>

            {{-- Rounds Card --}}
            <a href="{{ route('tournaments.matches', $tournament->id) }}"
                class="pixel-card p-4 md:p-6 bg-white relative overflow-hidden group hover:-translate-y-1 transition-transform duration-200 cursor-pointer block">
                <div class="absolute top-0 right-0 p-2 md:p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="h-16 w-16 md:h-24 md:w-24 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <div class="flex items-center relative z-10">
                    <div class="flex-shrink-0 bg-green-100 border-2 border-black shadow-pixel-sm p-2 md:p-3">
                        <svg class="h-6 w-6 md:h-8 md:w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <p class="text-xs md:text-sm font-pixel text-slate-500 uppercase tracking-widest">Rounds</p>
                        <p class="text-2xl md:text-4xl font-pixel text-green-600">{{ $tournament->rounds->count() ?? 0 }}</p>
                    </div>
                </div>
            </a>

            {{-- Speakers Card --}}
            <a href="{{ route('tournaments.participants', $tournament->id) }}"
                class="pixel-card p-4 md:p-6 bg-white relative overflow-hidden group hover:-translate-y-1 transition-transform duration-200 cursor-pointer block">
                <div class="absolute top-0 right-0 p-2 md:p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="h-16 w-16 md:h-24 md:w-24 text-england-red" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                    </svg>
                </div>
                <div class="flex items-center relative z-10">
                    <div class="flex-shrink-0 bg-england-red border-2 border-black shadow-pixel-sm p-2 md:p-3">
                        <svg class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <p class="text-xs md:text-sm font-pixel text-slate-500 uppercase tracking-widest">Speakers</p>
                        <p class="text-2xl md:text-4xl font-pixel text-england-red">{{ $tournament->teams->sum(fn($t) => $t->speakers->count()) }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Content Area -->
        <div class="grid grid-cols-1 gap-6">
            <!-- About Tournament -->
            <div class="pixel-card p-6">
                <h3 class="text-xl font-pixel text-england-blue mb-4 border-b-2 border-slate-100 pb-2">📖 ABOUT THE
                    TOURNAMENT</h3>
                <div class="prose prose-slate text-base text-slate-700 font-sans leading-relaxed">
                    <p>{{ $tournament->description ?? 'Welcome to the official page for this tournament. Here you can find all the latest updates, standings, and match draws.' }}
                    </p>
                </div>
            </div>

            <!-- Announcements -->
            <div class="pixel-card p-6">
                <h3 class="text-xl font-pixel text-england-red mb-4 border-b-2 border-slate-100 pb-2">📣 ANNOUNCEMENTS</h3>
                <ul role="list" class="space-y-4">
                    @php
                        $latestRound = $tournament->rounds->where('is_draw_published', true)->sortByDesc('updated_at')->first();
                    @endphp

                    @if($latestRound)
                        <li class="relative flex gap-x-4 p-4 bg-yellow-50 border-2 border-yellow-200 shadow-sm rounded-none">
                            <div class="flex-auto">
                                <div class="flex items-baseline justify-between gap-x-4">
                                    <p class="text-lg font-pixel text-yellow-800">🎯 {{ $latestRound->name }} Draw Released</p>
                                    <p class="flex-none text-xs font-bold text-yellow-600 uppercase tracking-wide">
                                        ⏰ {{ $latestRound->updated_at->diffForHumans() }}
                                    </p>
                                </div>
                                <p class="mt-1 text-sm leading-6 text-yellow-700 font-sans">
                                    The draw for {{ $latestRound->name }} is now live.
                                    Please check your room assignments.
                                </p>
                            </div>
                        </li>
                    @else
                        <li class="relative flex gap-x-4 p-4 bg-slate-50 border-2 border-slate-200 shadow-sm rounded-none">
                            <div class="flex-auto">
                                <p class="text-lg font-pixel text-slate-600">No Announcements Yet</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500 font-sans">
                                    Check back later for updates.
                                </p>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { hour12: false });
            const dateString = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = `${dateString} | ${timeString}`;
            }
        }
        
        setInterval(updateTime, 1000);
        updateTime(); // Initial call
    </script>
@endsection