@extends('layouts.user')

@section('content')

    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2 mb-2">
                <span
                    class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset bg-indigo-50 text-indigo-700 ring-indigo-600/20">
                    {{ $tournament->format ?? 'AP' }}
                </span>
                <span class="text-sm text-slate-500">{{ $tournament->year ?? date('Y') }}</span>
            </div>
            <h1 class="text-4xl font-bold leading-tight bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                🏆 {{ $tournament->name ?? 'Tournament Name' }}
            </h1>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <!-- Action buttons if needed -->
        </div>
    </div>

    <!-- Tabs -->
    <div class="mt-8 border-b border-slate-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a href="/tournaments/{{ $tournament->id ?? 1 }}"
                class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium"
                aria-current="page">
                🏠 Overview
            </a>
            <a href="/tournaments/{{ $tournament->id ?? 1 }}/standings"
                class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                🏆 Standings
            </a>
            <a href="/tournaments/{{ $tournament->id ?? 1 }}/matches"
                class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                ⚔️ Matches &amp; Draw
            </a>
            <a href="/tournaments/{{ $tournament->id ?? 1 }}/motions"
                class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                💡 Motions
            </a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                <h3 class="text-base font-semibold leading-7 text-slate-900 mb-4">📖 About the Tournament</h3>
                <div class="prose prose-slate text-sm text-slate-600">
                    <p>{{ $tournament->description ?? 'Welcome to the official page for this tournament. Here you can find all the latest updates, standings, and match draws.' }}
                    </p>
                </div>
            </div>

            <!-- Recent Updates / Announcements -->
            <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                <h3 class="text-base font-semibold leading-7 text-slate-900 mb-4">📣 Announcements</h3>
                <ul role="list" class="space-y-4">
                    <li class="relative flex gap-x-4 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg">
                        <div class="flex-auto">
                            <div class="flex items-baseline justify-between gap-x-4">
                                <p class="text-sm font-semibold leading-6 text-slate-900">🎯 Round 1 Draw Released</p>
                                <p class="flex-none text-xs text-slate-500">⏰ 1h ago</p>
                            </div>
                            <p class="mt-1 text-sm leading-6 text-slate-600">The draw for Round 1 is now live. Please
                                check your room assignments.</p>
                        </div>
                    </li>
                    <!-- More items... -->
                </ul>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-white to-slate-50 shadow-lg ring-1 ring-slate-200 rounded-xl p-6">
                <h3 class="text-sm font-bold leading-6 text-slate-900 mb-4 flex items-center gap-2">
                    📊 Statistics
                </h3>
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-1">
                    <div class="border-l-4 border-indigo-500 bg-gradient-to-r from-indigo-50 to-blue-50 pl-4 py-3 rounded-r-lg shadow-sm">
                        <dt class="text-xs font-medium text-slate-600 flex items-center gap-1">
                            👥 Total Teams
                        </dt>
                        <dd class="text-2xl font-bold tracking-tight bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">
                            {{ $tournament->teams_count ?? 0 }}
                        </dd>
                    </div>
                    <div class="border-l-4 border-violet-500 bg-gradient-to-r from-violet-50 to-purple-50 pl-4 py-3 rounded-r-lg shadow-sm">
                        <dt class="text-xs font-medium text-slate-600 flex items-center gap-1">
                            ⚖️ Adjudicators
                        </dt>
                        <dd class="text-2xl font-bold tracking-tight bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                            {{ $tournament->adjudicators_count ?? 0 }}
                        </dd>
                    </div>
                    <div class="border-l-4 border-fuchsia-500 bg-gradient-to-r from-fuchsia-50 to-pink-50 pl-4 py-3 rounded-r-lg shadow-sm">
                        <dt class="text-xs font-medium text-slate-600 flex items-center gap-1">
                            🔁 Rounds
                        </dt>
                        <dd class="text-2xl font-bold tracking-tight bg-gradient-to-r from-fuchsia-600 to-pink-600 bg-clip-text text-transparent">
                            {{ $tournament->rounds_count ?? 0 }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

@endsection