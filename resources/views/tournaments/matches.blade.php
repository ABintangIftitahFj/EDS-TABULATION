@extends('layouts.user')

@section('title', 'Matches - ' . $tournament->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                ⚔️ MATCHES: {{ $tournament->name }}
            </h1>
        </div>

        {{-- Tabs Navigation --}}
        <div class="border-b-4 border-slate-200 mb-8 overflow-x-auto pb-1">
            <nav class="-mb-1 flex space-x-8 min-w-max" aria-label="Tabs">
                <a href="/tournaments" class="pixel-tab text-slate-600 hover:text-black">
                    ← ALL TOURNAMENTS
                </a>
                <a href="/tournaments/{{ $tournament->id }}" class="pixel-tab text-slate-600 hover:text-black">
                    🏠 OVERVIEW
                </a>
                <a href="/tournaments/{{ $tournament->id }}/motions" class="pixel-tab text-slate-600 hover:text-black">
                    💡 MOTIONS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/standings" class="pixel-tab text-slate-600 hover:text-black">
                    🏆 STANDINGS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/matches" class="pixel-tab pixel-tab-active">
                    ⚔️ MATCHES & DRAW
                </a>
                <a href="/tournaments/{{ $tournament->id }}/results" class="pixel-tab text-slate-600 hover:text-black">
                    📊 RESULTS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/speakers" class="pixel-tab text-slate-600 hover:text-black">
                    🎤 SPEAKERS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/adjudicators" class="pixel-tab text-slate-600 hover:text-black">
                    ⚖️ ADJUDICATORS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/participants" class="pixel-tab text-slate-600 hover:text-black">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        <div class="space-y-6"
            x-data="{ selectedRound: '{{ $tournament->rounds->sortBy('created_at')->first()->id ?? '' }}' }">

            {{-- Header & Dropdown Selection --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pixel-card p-4 bg-soft-pink/20">
                <div>
                    <h3 class="text-xl font-pixel text-england-blue">MATCH LIST</h3>
                    <p class="text-sm font-sans text-slate-600">Select a round to view the draw.</p>
                </div>

                <div class="w-full sm:w-64">
                    @if($tournament->rounds->count() > 0)
                        <select x-model="selectedRound" class="pixel-input block w-full bg-white text-lg font-pixel">
                            @foreach($tournament->rounds->sortBy('created_at') as $round)
                                <option value="{{ $round->id }}">
                                    {{ $round->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <span class="text-sm font-pixel text-england-red bg-white px-2 py-1 border-2 border-england-red">NO
                            ROUNDS YET</span>
                    @endif
                </div>
            </div>

            {{-- Matches List Area --}}
            <div class="pixel-card overflow-hidden bg-white">
                @if($tournament->rounds->count() > 0)
                    @foreach($tournament->rounds as $round)
                        <div x-show="selectedRound == '{{ $round->id }}'" style="display: none;">

                            {{-- Round Info Header --}}
                            <div class="px-6 py-4 border-b-4 border-slate-200 bg-slate-50">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-pixel text-2xl text-england-blue">{{ $round->name }}</h4>
                                    <span
                                        class="px-3 py-1 text-sm font-pixel border-2 border-black shadow-pixel-sm {{ $round->is_published ? 'bg-green-400 text-black' : 'bg-yellow-300 text-black' }}">
                                        {{ $round->is_published ? 'PUBLISHED' : 'DRAFT' }}
                                    </span>
                                </div>
                                @if($round->is_motion_published && $round->motion)
                                    <div class="mt-4 p-3 bg-white border-2 border-slate-300 shadow-sm">
                                        <span class="font-pixel text-england-red uppercase mr-2">Motion:</span>
                                        <span class="font-serif italic text-lg text-black">"{{ $round->motion }}"</span>
                                    </div>
                                @elseif(!$round->is_motion_published)
                                    <div class="mt-4 p-3 bg-yellow-50 border-2 border-yellow-300 shadow-sm">
                                        <span class="font-pixel text-yellow-700">Motion belum dipublikasikan</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Matches Table --}}
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y-2 divide-slate-200">
                                    <thead class="bg-england-blue text-white">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                                Venue</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                                Proposition (Gov)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                                VS</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                                Opposition (Opp)</th>
                                            <th scope="col" class="px-6 py-3 text-center text-lg font-pixel tracking-wider">
                                                Adjudicators</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y-2 divide-slate-100">
                                        @forelse($round->matches as $match)
                                            <tr class="hover:bg-soft-pink/10 transition-colors">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-base font-bold font-sans text-black border-r border-slate-100">
                                                    📍 {{ $match->room->name ?? 'TBA' }}
                                                </td>

                                                {{-- Team Gov --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                                    <div class="text-base font-bold text-black font-sans">
                                                        {{ $match->govTeam->emoji ?? '🛡️' }}
                                                        {{ $match->govTeam->name ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 font-mono">
                                                        {{ $match->govTeam->institution ?? '' }}
                                                    </div>
                                                </td>

                                                {{-- VS Badge or Status --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                                    @if($match->is_completed)
                                                        <div class="flex flex-col items-center gap-2">
                                                            <span
                                                                class="inline-flex items-center justify-center px-3 py-1 text-sm font-pixel text-white bg-green-600 border-2 border-black shadow-pixel-sm">
                                                                ✓ BALLOT FILLED
                                                            </span>
                                                            @if($round->results_published)
                                                                {{-- Calculate total scores from ballots + reply scores --}}
                                                                @php
                                                                    $govScore = $match->ballots->where('team_role', 'gov')->sum('score') + ($match->gov_reply_score ?? 0);
                                                                    $oppScore = $match->ballots->where('team_role', 'opp')->sum('score') + ($match->opp_reply_score ?? 0);
                                                                @endphp
                                                                <div class="text-lg font-pixel text-black">
                                                                    {{ $govScore }} - {{ $oppScore }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center justify-center px-2 py-1 text-xl font-pixel text-white bg-england-red border-2 border-black shadow-pixel-sm transform rotate-12">
                                                            VS
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- Team Opp --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                                    <div class="text-base font-bold text-black font-sans">
                                                        {{ $match->oppTeam->emoji ?? '🔥' }}
                                                        {{ $match->oppTeam->name ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 font-mono">
                                                        {{ $match->oppTeam->institution ?? '' }}
                                                    </div>
                                                </td>

                                                {{-- Adjudicators --}}
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex flex-col items-center gap-1">
                                                        @if($match->adjudicator)
                                                            <span
                                                                class="inline-flex items-center px-3 py-1 border-2 border-blue-800 text-xs font-pixel bg-blue-100 text-blue-900 shadow-sm">
                                                                ⚖️ {{ $match->adjudicator->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-xs font-pixel text-slate-400">NO ADJUDICATOR</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-10 text-center text-lg font-pixel text-slate-500">
                                                    No pairings available for this round.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-10 text-center">
                        <div class="inline-block p-4 bg-slate-100 rounded-full mb-4 border-4 border-slate-200">
                            <svg class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-xl font-pixel text-black">NO DATA</h3>
                        <p class="mt-1 text-sm font-sans text-slate-500">Match schedule is not yet available.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection