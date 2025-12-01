@extends('layouts.user')

@section('title', 'Results - ' . $tournament->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                📊 RESULTS: {{ $tournament->name }}
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
                    class="pixel-tab text-slate-600 hover:text-black">
                    🏆 STANDINGS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/matches"
                    class="pixel-tab text-slate-600 hover:text-black">
                    ⚔️ MATCHES & DRAW
                </a>
                <a href="/tournaments/{{ $tournament->id }}/results"
                    class="pixel-tab pixel-tab-active">
                    📊 RESULTS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/speakers"
                    class="pixel-tab text-slate-600 hover:text-black">
                    🎤 SPEAKERS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/adjudicators"
                    class="pixel-tab text-slate-600 hover:text-black">
                    ⚖️ ADJUDICATORS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/participants"
                    class="pixel-tab text-slate-600 hover:text-black">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        {{-- Round Filter --}}
        <div class="mb-6">
            <div class="pixel-card p-6 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-pixel text-black mb-0">FILTER RESULTS BY ROUND</h3>
                    <form method="GET" action="/tournaments/{{ $tournament->id }}/results" class="flex items-center gap-4">
                        <select name="round_id" onchange="this.form.submit()"
                            class="pixel-input rounded-none border-2 border-black shadow-pixel-sm text-sm font-pixel py-2 pl-3 pr-10">
                            <option value="">📋 ALL ROUNDS</option>
                            @foreach($allRounds as $round)
                                <option value="{{ $round->id }}" {{ $roundId == $round->id ? 'selected' : '' }}>
                                    {{ $round->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($roundId)
                            <a href="/tournaments/{{ $tournament->id }}/results"
                                class="pixel-btn bg-slate-200 text-black text-sm py-2 hover:bg-slate-300">
                                🗙 CLEAR
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- Results by Round --}}
        @forelse($tournament->rounds as $round)
            @if($round->matches->where('is_completed', true)->count() > 0)
                <div class="mb-12">
                    <h2 class="text-3xl font-pixel text-england-blue mb-6 flex items-center gap-3 border-b-4 border-england-red pb-2 inline-block">
                        📢 {{ $round->name }}
                        @if($roundId)
                            <span class="px-3 py-1 bg-soft-pink text-england-blue text-sm font-pixel border-2 border-black shadow-pixel-sm transform rotate-3">
                                FILTERED
                            </span>
                        @endif
                    </h2>

                    {{-- Motion Display --}}
                    <div class="pixel-card p-6 mb-8 bg-gradient-to-r from-purple-50 to-indigo-50 border-l-8 border-l-purple-500">
                        <div class="flex items-start gap-4">
                            <span class="text-4xl">💡</span>
                            <div>
                                <p class="text-sm font-pixel text-slate-500 uppercase tracking-widest mb-1">Motion</p>
                                <p class="text-xl font-serif italic text-black leading-relaxed">"{{ $round->motion }}"</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        @foreach($round->matches->where('is_completed', true) as $match)
                            <div class="pixel-card overflow-hidden bg-white hover:shadow-pixel-lg transition-shadow duration-300">

                                {{-- Match Header --}}
                                <div class="bg-slate-100 px-6 py-4 border-b-2 border-slate-900 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <span class="text-base font-bold font-sans text-black bg-white px-3 py-1 border-2 border-slate-300 shadow-sm">
                                            📍 {{ $match->room->name ?? 'Room TBA' }}
                                        </span>
                                        <span class="text-sm font-pixel text-slate-500 uppercase">
                                            ⚖️ {{ $match->adjudicator->name ?? 'Adjudicator TBA' }}
                                        </span>
                                    </div>
                                    @if($match->winner)
                                        <span
                                            class="px-4 py-1 bg-green-400 text-black text-sm font-pixel border-2 border-black shadow-pixel-sm transform -rotate-2">
                                            ✅ WINNER: {{ $match->winner->name }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Team Results Grid --}}
                                <div class="grid md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x-2 divide-slate-900">

                                    {{-- GOV Team --}}
                                    <div
                                        class="p-6 {{ $match->winner_id == $match->gov_team_id ? 'bg-green-50' : 'bg-white' }}">
                                        <div class="flex items-center justify-between mb-6">
                                            <h3 class="font-bold text-xl text-black flex items-center gap-2 font-sans">
                                                🛡️ {{ $match->govTeam->name ?? 'Government' }}
                                            </h3>
                                            <span class="px-3 py-1 bg-england-blue text-white text-xs font-pixel border-2 border-black shadow-sm">GOV</span>
                                        </div>

                                        {{-- Speakers & Scores --}}
                                        <div class="space-y-3">
                                            @php
                                                $govBallots = $match->ballots->where('team_role', 'gov');
                                                $govTotal = $govBallots->sum('score');
                                            @endphp
                                            @if($round->results_published)
                                                @foreach($govBallots as $ballot)
                                                    <div class="flex justify-between items-center p-3 bg-white border-2 border-slate-200 shadow-sm">
                                                        <span class="text-sm font-bold text-black font-sans">
                                                            {{ $ballot->speaker->name ?? 'Speaker' }}
                                                        </span>
                                                        <span class="text-lg font-pixel text-england-blue">
                                                            {{ $ballot->score }} pts
                                                        </span>
                                                    </div>
                                                @endforeach

                                                <div class="mt-4 pt-4 border-t-2 border-slate-900 border-dashed flex justify-between items-center">
                                                    <span class="text-sm font-pixel text-slate-500 uppercase">Total Score</span>
                                                    <span class="text-2xl font-pixel text-black">{{ $govTotal }}</span>
                                                </div>
                                            @else
                                                <div class="p-6 text-center bg-slate-50 border-2 border-slate-200 border-dashed">
                                                    <p class="text-sm font-pixel text-slate-400">🔒 Speaker scores hidden</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- OPP Team --}}
                                    <div
                                        class="p-6 {{ $match->winner_id == $match->opp_team_id ? 'bg-green-50' : 'bg-white' }}">
                                        <div class="flex items-center justify-between mb-6">
                                            <h3 class="font-bold text-xl text-black flex items-center gap-2 font-sans">
                                                🔥 {{ $match->oppTeam->name ?? 'Opposition' }}
                                            </h3>
                                            <span class="px-3 py-1 bg-england-red text-white text-xs font-pixel border-2 border-black shadow-sm">OPP</span>
                                        </div>

                                        {{-- Speakers & Scores --}}
                                        <div class="space-y-3">
                                            @php
                                                $oppBallots = $match->ballots->where('team_role', 'opp');
                                                $oppTotal = $oppBallots->sum('score');
                                            @endphp
                                            @if($round->results_published)
                                                @foreach($oppBallots as $ballot)
                                                    <div class="flex justify-between items-center p-3 bg-white border-2 border-slate-200 shadow-sm">
                                                        <span class="text-sm font-bold text-black font-sans">
                                                            {{ $ballot->speaker->name ?? 'Speaker' }}
                                                        </span>
                                                        <span class="text-lg font-pixel text-england-red">
                                                            {{ $ballot->score }} pts
                                                        </span>
                                                    </div>
                                                @endforeach

                                                <div class="mt-4 pt-4 border-t-2 border-slate-900 border-dashed flex justify-between items-center">
                                                    <span class="text-sm font-pixel text-slate-500 uppercase">Total Score</span>
                                                    <span class="text-2xl font-pixel text-black">{{ $oppTotal }}</span>
                                                </div>
                                            @else
                                                <div class="p-6 text-center bg-slate-50 border-2 border-slate-200 border-dashed">
                                                    <p class="text-sm font-pixel text-slate-400">🔒 Speaker scores hidden</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Adjudicator Review Section --}}
                                <div class="bg-slate-50 px-6 py-4 border-t-2 border-slate-900">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <h4 class="text-sm font-pixel text-black mb-1 uppercase">
                                                ⭐ Rate Adjudicator
                                            </h4>
                                            <p class="text-xs text-slate-500 font-sans">Help improve judging quality.</p>
                                        </div>

                                        <button
                                            onclick="document.getElementById('review-modal-{{ $match->id }}').classList.remove('hidden')"
                                            class="pixel-btn bg-white text-black text-xs py-2 hover:bg-yellow-50">
                                            LEAVE REVIEW
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Review Modal --}}
                            <div id="review-modal-{{ $match->id }}"
                                class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                                <div class="pixel-card w-full max-w-md bg-white p-6 relative">
                                    <button
                                        onclick="document.getElementById('review-modal-{{ $match->id }}').classList.add('hidden')"
                                        class="absolute top-4 right-4 text-black hover:text-england-red">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    <h3 class="text-2xl font-pixel text-black mb-6 border-b-4 border-soft-pink inline-block">RATE ADJUDICATOR</h3>

                                    <form action="{{ route('public.adjudicator-reviews.store', $match) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="adjudicator_id" value="{{ $match->adjudicator->id ?? '' }}">
                                        <div class="space-y-6">
                                            <div>
                                                <label class="block text-sm font-pixel text-slate-500 uppercase mb-2">Adjudicator</label>
                                                <p class="text-lg font-bold font-sans text-black bg-slate-100 p-2 border-2 border-slate-200">{{ $match->adjudicator->name ?? 'N/A' }}</p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-pixel text-slate-500 uppercase mb-2">Rating</label>
                                                <div class="flex gap-2 justify-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label class="cursor-pointer group relative">
                                                            <input type="radio" name="rating" value="{{ $i }}" required
                                                                class="sr-only peer">
                                                            <span class="text-5xl transition-all duration-200 
                                                                peer-checked:scale-110 
                                                                peer-checked:filter-none
                                                                group-hover:scale-110 
                                                                group-hover:filter-none
                                                                filter grayscale">⭐</span>
                                                        </label>
                                                    @endfor
                                                </div>
                                                <p class="text-xs text-center text-slate-400 mt-2 font-sans">Click on stars to rate (1-5)</p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-pixel text-slate-500 uppercase mb-2">Comment</label>
                                                <textarea name="comment" rows="3"
                                                    class="pixel-input w-full p-3"
                                                    placeholder="Share your feedback..."></textarea>
                                            </div>

                                            <div class="flex gap-4 pt-4">
                                                <button type="submit"
                                                    class="pixel-btn pixel-btn-primary flex-1">
                                                    SUBMIT
                                                </button>
                                                <button type="button"
                                                    onclick="document.getElementById('review-modal-{{ $match->id }}').classList.add('hidden')"
                                                    class="pixel-btn bg-slate-200 hover:bg-slate-300 text-black">
                                                    CANCEL
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @empty
            <div class="pixel-card p-12 text-center bg-white">
                <div class="inline-block p-6 bg-slate-100 rounded-full border-4 border-slate-200 mb-6">
                    <svg class="h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-pixel text-black mb-2">
                    @if($roundId)
                        NO MATCHES FOUND
                    @else
                        NO RESULTS YET
                    @endif
                </h3>
                <p class="text-base font-sans text-slate-500">
                    @if($roundId)
                        This round has no completed matches yet.
                    @else
                        Completed matches will appear here.
                    @endif
                </p>
            </div>
        @endforelse
    </div>
@endsection