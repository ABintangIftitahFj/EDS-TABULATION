@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span
                        class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset bg-indigo-50 text-indigo-700 ring-indigo-600/20">
                        {{ $tournament->format ?? 'AP' }}
                    </span>
                    <span class="text-sm text-black">{{ $tournament->year ?? date('Y') }}</span>
                </div>
                <h1 class="text-4xl font-bold leading-tight text-purple-700">
                    🏆 {{ $tournament->name ?? 'Tournament Name' }}
                </h1>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-slate-200 mb-8">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="/tournaments"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    ← All Tournaments
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}"
                    class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🏠 Overview
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/standings"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🏆 Standings
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/matches"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    ⚔️ Matches & Draw
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/results"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    📊 Results
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/speakers"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🎤 Speakers
                </a>
                <a href="/tournaments/{{ $tournament->id ?? 1 }}/motions"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    💡 Motions
                </a>
            </nav>
        </div>

        <!-- Statistics Cards (Horizontal) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-black">Total Teams</p>
                        <p class="text-2xl font-bold text-black">{{ $tournament->teams->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-violet-100 rounded-lg p-3">
                        <svg class="h-6 w-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-black">Adjudicators</p>
                        <p class="text-2xl font-bold text-black">{{ $tournament->adjudicators->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-fuchsia-100 rounded-lg p-3">
                        <svg class="h-6 w-6 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-black">Rounds</p>
                        <p class="text-2xl font-bold text-black">{{ $tournament->rounds->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="grid grid-cols-1 gap-6">
            <!-- About Tournament -->
            <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                <h3 class="text-base font-semibold leading-7 text-black mb-4">📖 About the Tournament</h3>
                <div class="prose prose-slate text-sm text-black">
                    <p>{{ $tournament->description ?? 'Welcome to the official page for this tournament. Here you can find all the latest updates, standings, and match draws.' }}
                    </p>
                </div>
            </div>

            <!-- Announcements -->
            <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                <h3 class="text-base font-semibold leading-7 text-black mb-4">📣 Announcements</h3>
                <ul role="list" class="space-y-4">
                    <li class="relative flex gap-x-4 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg">
                        <div class="flex-auto">
                            <div class="flex items-baseline justify-between gap-x-4">
                                <p class="text-sm font-semibold leading-6 text-black">🎯 Round 1 Draw Released</p>
                                <p class="flex-none text-xs text-black">⏰ 1h ago</p>
                            </div>
                            <p class="mt-1 text-sm leading-6 text-black">The draw for Round 1 is now live. Please check
                                your room assignments.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection