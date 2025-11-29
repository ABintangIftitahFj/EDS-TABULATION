@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                🏆 STANDINGS: {{ $tournament->name }}
            </h1>
        </div>

        {{-- Tabs Navigation --}}
        <div class="border-b-4 border-slate-200 mb-8 overflow-x-auto pb-1">
            <nav class="-mb-1 flex space-x-8 min-w-max" aria-label="Tabs">
                <a href="/tournaments"
                    class="pixel-tab text-slate-600 hover:text-black">
                    ← ALL TOURNAMENTS
                </a>
                <a href="/tournaments/{{ $tournament->id }}"
                    class="pixel-tab text-slate-600 hover:text-black">
                    🏠 OVERVIEW
                </a>
                <a href="/tournaments/{{ $tournament->id }}/motions"
                    class="pixel-tab text-slate-600 hover:text-black">
                    💡 MOTIONS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/standings"
                    class="pixel-tab pixel-tab-active">
                    🏆 STANDINGS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/matches"
                    class="pixel-tab text-slate-600 hover:text-black">
                    ⚔️ MATCHES & DRAW
                </a>
                <a href="/tournaments/{{ $tournament->id }}/results"
                    class="pixel-tab text-slate-600 hover:text-black">
                    📊 RESULTS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/speakers"
                    class="pixel-tab text-slate-600 hover:text-black">
                    🎤 SPEAKERS
                </a>
            </nav>
        </div>

        <!-- Standings Content -->
        <div class="mt-8" x-data="{ tab: 'teams' }">
            <!-- Sub-tabs for Team/Speaker -->
            <div class="sm:hidden mb-4">
                <label for="tabs" class="sr-only">Select a tab</label>
                <select id="tabs" name="tabs"
                    class="pixel-input block w-full"
                    x-model="tab">
                    <option value="teams">Team Standings</option>
                    <option value="speakers">Speaker Standings</option>
                </select>
            </div>
            <div class="hidden sm:block mb-6">
                <div class="border-b-2 border-slate-200">
                    <nav class="-mb-0.5 flex space-x-8" aria-label="Tabs">
                        <button @click="tab = 'teams'"
                            :class="tab === 'teams' ? 'border-england-blue text-england-blue' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap border-b-4 py-4 px-1 text-xl font-pixel transition-colors">
                            👥 TEAM STANDINGS
                        </button>
                        <button @click="tab = 'speakers'"
                            :class="tab === 'speakers' ? 'border-england-blue text-england-blue' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            class="whitespace-nowrap border-b-4 py-4 px-1 text-xl font-pixel transition-colors">
                            🎤 SPEAKER STANDINGS
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Team Standings -->
            <div x-show="tab === 'teams'" class="pixel-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-slate-900">
                        <thead class="bg-england-red text-white">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider border-r-2 border-slate-900/20">Rank
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider border-r-2 border-slate-900/20">Team
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider border-r-2 border-slate-900/20">
                                    Institution</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider border-r-2 border-slate-900/20">VP
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider">
                                    Speaker Score</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y-2 divide-slate-100">
                            @forelse($tournament->teams as $index => $team)
                                <tr
                                    class="{{ $index < 3 ? 'bg-yellow-50' : 'hover:bg-soft-pink/10' }} transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-pixel border-r border-slate-100">
                                        @if($index === 0)
                                            <span class="text-3xl drop-shadow-sm" title="1st Place">🥇</span>
                                        @elseif($index === 1)
                                            <span class="text-3xl drop-shadow-sm" title="2nd Place">🥈</span>
                                        @elseif($index === 2)
                                            <span class="text-3xl drop-shadow-sm" title="3rd Place">🥉</span>
                                        @else
                                            <span class="text-slate-600 font-bold">#{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="flex items-center gap-2">
                                            <span class="text-base font-bold text-black font-sans">{{ $team->emoji ?? '👥' }}
                                                {{ $team->name }}</span>
                                            @if($index < 4)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 border-2 border-indigo-900 text-xs font-pixel bg-indigo-100 text-indigo-900 shadow-sm">BREAK</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 font-sans border-r border-slate-100">🏦 {{ $team->institution }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-sm font-bold font-pixel bg-england-blue text-white border-2 border-black shadow-pixel-sm">
                                            ⚡ {{ $team->total_vp }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold font-mono text-black">
                                        {{ $team->total_speaker_score }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-lg font-pixel text-slate-500">
                                        No teams found or standings not yet generated.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Speaker Standings -->
            <div x-show="tab === 'speakers'" style="display: none;"
                class="pixel-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-slate-900">
                        <thead class="bg-england-blue text-white">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider border-r-2 border-white/20">Rank
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                    Speaker</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider border-r-2 border-white/20">Team
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                    Total Score</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-lg font-pixel tracking-wider">
                                    Average</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y-2 divide-slate-100">
                            @forelse($speakers as $index => $speaker)
                                <tr
                                    class="{{ $loop->iteration <= 3 ? 'bg-purple-50' : 'hover:bg-soft-pink/10' }} transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-pixel border-r border-slate-100">
                                        @if($loop->iteration === 1)
                                            <span class="text-3xl drop-shadow-sm" title="Best Speaker">🏆</span>
                                        @elseif($loop->iteration === 2)
                                            <span class="text-3xl drop-shadow-sm">🥈</span>
                                        @elseif($loop->iteration === 3)
                                            <span class="text-3xl drop-shadow-sm">🥉</span>
                                        @else
                                            <span class="text-slate-600 font-bold">#{{ $loop->iteration }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="flex items-center gap-2">
                                            <span class="text-base font-bold text-black font-sans">🎤 {{ $speaker->name }}</span>
                                            @if($loop->iteration === 1)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 border-2 border-yellow-700 text-xs font-pixel bg-yellow-100 text-yellow-800 shadow-sm">TOP</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 font-sans border-r border-slate-100">
                                        {{ $speaker->team->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-sm font-bold font-pixel bg-purple-600 text-white border-2 border-black shadow-pixel-sm">
                                            🎯 {{ $speaker->total_score }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold font-mono text-black">
                                        {{ $tournament->rounds_count > 0 ? number_format($speaker->total_score / max(1, $tournament->rounds_count), 2) : '0.00' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-lg font-pixel text-slate-500">
                                        No speakers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection