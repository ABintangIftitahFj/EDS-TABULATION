@extends('layouts.user')

@section('title', 'Results - ' . $tournament->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold leading-tight text-purple-700">
                📊 Results: {{ $tournament->name }}
            </h1>
        </div>

        {{-- Tabs Navigation --}}
        <div class="border-b border-slate-200 mb-8">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="/tournaments"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    ← All Tournaments
                </a>
                <a href="/tournaments/{{ $tournament->id }}"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🏠 Overview
                </a>
                <a href="/tournaments/{{ $tournament->id }}/standings"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🏆 Standings
                </a>
                <a href="/tournaments/{{ $tournament->id }}/matches"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    ⚔️ Matches & Draw
                </a>
                <a href="/tournaments/{{ $tournament->id }}/results"
                    class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium"
                    aria-current="page">
                    📊 Results
                </a>
                <a href="/tournaments/{{ $tournament->id }}/speakers"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🎤 Speakers
                </a>
                <a href="/tournaments/{{ $tournament->id }}/motions"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    💡 Motions
                </a>
            </nav>
        </div>

        {{-- Round Filter --}}
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-black mb-0">Filter Results by Round</h3>
                    <form method="GET" action="/tournaments/{{ $tournament->id }}/results" class="flex items-center gap-4">
                        <select name="round_id" onchange="this.form.submit()"
                            class="rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">📋 All Rounds</option>
                            @foreach($allRounds as $round)
                                <option value="{{ $round->id }}" {{ $roundId == $round->id ? 'selected' : '' }}>
                                    {{ $round->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($roundId)
                            <a href="/tournaments/{{ $tournament->id }}/results"
                                class="px-4 py-2 text-sm bg-slate-200 text-black rounded-lg hover:bg-slate-300 transition-colors">
                                🗙 Clear Filter
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- Results by Round --}}
        @forelse($tournament->rounds as $round)
            @if($round->matches->where('is_completed', true)->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-black mb-4 flex items-center gap-2">
                        <span class="text-purple-700">
                            📢 {{ $round->name }}
                        </span>
                        @if($roundId)
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full">
                                Filtered Results
                            </span>
                        @endif
                    </h2>

                    {{-- Motion Display --}}
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">💡</span>
                            <div>
                                <p class="text-sm font-medium text-black">Motion:</p>
                                <p class="text-lg font-semibold text-black">{{ $round->motion }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($round->matches->where('is_completed', true) as $match)
                            <div class="bg-white rounded-xl shadow-lg ring-1 ring-slate-200 overflow-hidden">

                                {{-- Match Header --}}
                                <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm font-semibold text-black">📍
                                                {{ $match->room->name ?? 'Room TBA' }}</span>
                                            <span class="text-xs text-black">•</span>
                                            <span class="text-sm text-black">⚖️
                                                {{ $match->adjudicator->name ?? 'Adjudicator TBA' }}</span>
                                        </div>
                                        @if($match->winner)
                                            <span
                                                class="px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-500 text-black text-xs font-bold rounded-full shadow-md">
                                                ✅ Winner: {{ $match->winner->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Team Results Grid --}}
                                <div class="grid md:grid-cols-2 gap-6 p-6">
                                    
                                    {{-- GOV Team --}}
                                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-lg p-4 border-2 {{ $match->winner_id == $match->gov_team_id ? 'border-green-500 ring-2 ring-green-200' : 'border-indigo-200' }}">
                                        <div class="flex items-center justify-between mb-3">
                                            <h3 class="font-bold text-lg text-indigo-900 flex items-center gap-2">
                                                🛡️ {{ $match->govTeam->name ?? 'Government' }}
                                            </h3>
                                            <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full">GOV</span>
                                        </div>
                                        
                                        {{-- Speakers & Scores --}}
                                        <div class="space-y-2">
                                            @php
                                                $govBallots = $match->ballots->where('team_role', 'gov');
                                                $govTotal = $govBallots->sum('score');
                                            @endphp
                                            @foreach($govBallots as $ballot)
                                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm font-medium text-black">
                                                            {{ $ballot->speaker->name ?? 'Speaker' }}
                                                        </span>
                                                        <span class="text-lg font-bold text-indigo-600">
                                                            {{ $ballot->score }} pts
                                                        </span>
                                                    </div>
                                                    @if($ballot->feedback)
                                                        <p class="text-xs text-black mt-1 italic">"{{ $ballot->feedback }}"</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                            
                                            <div class="bg-indigo-100 rounded-lg p-3 mt-3">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm font-bold text-indigo-900">Total Score</span>
                                                    <span class="text-xl font-bold text-indigo-700">{{ $govTotal }} pts</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- OPP Team --}}
                                    <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-lg p-4 border-2 {{ $match->winner_id == $match->opp_team_id ? 'border-green-500 ring-2 ring-green-200' : 'border-rose-200' }}">
                                        <div class="flex items-center justify-between mb-3">
                                            <h3 class="font-bold text-lg text-rose-900 flex items-center gap-2">
                                                🔥 {{ $match->oppTeam->name ?? 'Opposition' }}
                                            </h3>
                                            <span class="px-3 py-1 bg-rose-600 text-white text-xs font-bold rounded-full">OPP</span>
                                        </div>
                                        
                                        {{-- Speakers & Scores --}}
                                        <div class="space-y-2">
                                            @php
                                                $oppBallots = $match->ballots->where('team_role', 'opp');
                                                $oppTotal = $oppBallots->sum('score');
                                            @endphp
                                            @foreach($oppBallots as $ballot)
                                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm font-medium text-black">
                                                            {{ $ballot->speaker->name ?? 'Speaker' }}
                                                        </span>
                                                        <span class="text-lg font-bold text-rose-600">
                                                            {{ $ballot->score }} pts
                                                        </span>
                                                    </div>
                                                    @if($ballot->feedback)
                                                        <p class="text-xs text-black mt-1 italic">"{{ $ballot->feedback }}"</p>
                                                    @endif
                                                </div>
                                            @endforeach

                                            <div class="bg-rose-100 rounded-lg p-3 mt-3">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm font-bold text-rose-900">Total Score</span>
                                                    <span class="text-xl font-bold text-rose-700">{{ $oppTotal }} pts</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Adjudicator Review Section --}}
                                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-black mb-2 flex items-center gap-2">
                                                ⚖️ Rate Adjudicator Performance
                                            </h4>
                                            <p class="text-xs text-black">Help us improve judging quality by rating this adjudicator</p>
                                        </div>

                                        <button
                                            onclick="document.getElementById('review-modal-{{ $match->id }}').classList.remove('hidden')"
                                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-black text-sm font-semibold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-md">
                                            ⭐ Leave Review
                                        </button>
                                    </div>

                                    {{-- Existing Reviews --}}
                                    @if($match->adjudicatorReviews && $match->adjudicatorReviews->count() > 0)
                                        <div class="mt-4 space-y-2">
                                            <p class="text-xs font-semibold text-black mb-2">Recent Reviews:</p>
                                            @foreach($match->adjudicatorReviews->take(3) as $review)
                                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-yellow-500 text-sm">
                                                            @for($i = 0; $i < $review->rating; $i++) ⭐ @endfor
                                                        </span>
                                                        <span class="text-xs text-black">{{ $review->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    @if($review->comment)
                                                        <p class="text-xs text-black italic">"{{ $review->comment }}"</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Review Modal --}}
                            <div id="review-modal-{{ $match->id }}"
                                class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                                <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-bold text-black">⚖️ Rate Adjudicator</h3>
                                        <button
                                            onclick="document.getElementById('review-modal-{{ $match->id }}').classList.add('hidden')"
                                            class="text-black hover:text-black">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <form action="{{ route('admin.adjudicator-reviews.store', $match) }}" method="POST">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-black mb-2">Adjudicator</label>
                                                <p class="text-sm text-black font-semibold">{{ $match->adjudicator->name ?? 'N/A' }}</p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-black mb-2">Rating (1-5 stars)</label>
                                                <div class="flex gap-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label class="cursor-pointer">
                                                            <input type="radio" name="rating" value="{{ $i }}" required
                                                                class="sr-only peer">
                                                            <span
                                                                class="text-3xl peer-checked:text-yellow-500 text-black hover:text-yellow-400 transition-colors">⭐</span>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-black mb-2">Comment (optional)</label>
                                                <textarea name="comment" rows="3"
                                                    class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                                    placeholder="Share your feedback about the adjudication..."></textarea>
                                            </div>

                                            <div class="flex gap-3">
                                                <button type="submit"
                                                    class="flex-1 px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-black font-semibold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-md">
                                                    Submit Review
                                                </button>
                                                <button type="button"
                                                    onclick="document.getElementById('review-modal-{{ $match->id }}').classList.add('hidden')"
                                                    class="px-4 py-2 bg-slate-200 text-black font-semibold rounded-lg hover:bg-slate-300 transition-colors">
                                                    Cancel
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
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-black mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-medium text-black mb-2">
                    @if($roundId)
                        No Completed Matches in This Round
                    @else
                        No Results Available
                    @endif
                </h3>
                <p class="text-sm text-black">
                    @if($roundId)
                        This round has no completed matches yet. Try selecting a different round or clear the filter.
                    @else
                        Completed matches will appear here with detailed ballot results
                    @endif
                </p>
            </div>
        @endforelse
    </div>
@endsection