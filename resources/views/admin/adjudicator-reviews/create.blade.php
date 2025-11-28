@extends('layouts.admin')

@section('title', 'Adjudicator Reviews - Match #' . $match->id)

@section('content')
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.matches.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Adjudicator Reviews</h1>
                <p class="text-slate-500 mt-1">
                    {{ $match->govTeam->name }} vs {{ $match->oppTeam->name }} • Round {{ $match->round->name }}
                </p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Match Info Card -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-sm font-medium text-slate-500 mb-2">Government Team</h3>
                <p class="text-lg font-bold text-blue-600">{{ $match->govTeam->name }}</p>
                <p class="text-sm text-slate-500">{{ $match->govTeam->institution }}</p>
            </div>
            <div class="text-center">
                <h3 class="text-sm font-medium text-slate-500 mb-2">VS</h3>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $match->status === 'finished' ? 'bg-green-100 text-green-800' : ($match->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-800') }}">
                    {{ ucfirst(str_replace('_', ' ', $match->status)) }}
                </span>
            </div>
            <div class="text-right">
                <h3 class="text-sm font-medium text-slate-500 mb-2">Opposition Team</h3>
                <p class="text-lg font-bold text-purple-600">{{ $match->oppTeam->name }}</p>
                <p class="text-sm text-slate-500">{{ $match->oppTeam->institution }}</p>
            </div>
        </div>

        @if ($match->status === 'finished')
            <div class="mt-6 pt-6 border-t border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <p class="text-sm text-slate-500 mb-1">Final Score (Gov)</p>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($match->final_score_team_a, 2) }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-slate-500 mb-1">Winner</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $match->winnerTeam ? $match->winnerTeam->name : 'Draw' }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-slate-500 mb-1">Final Score (Opp)</p>
                        <p class="text-3xl font-bold text-purple-600">{{ number_format($match->final_score_team_b, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Existing Reviews -->
    @if ($existingReviews->count() > 0)
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 mb-6">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                <h3 class="text-lg font-semibold text-slate-900">Submitted Reviews
                    ({{ $existingReviews->count() }})</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($existingReviews as $review)
                        <div class="border border-slate-200 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="bg-indigo-100 rounded-lg p-2">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-slate-900">{{ $review->adjudicator->name }}</h4>
                                            <p class="text-sm text-slate-500">{{ $review->adjudicator->institution }}</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="bg-blue-50 rounded-lg p-3">
                                            <p class="text-xs text-blue-600 font-medium mb-1">Gov Score</p>
                                            <p class="text-2xl font-bold text-blue-700">{{ $review->score_team_a }}</p>
                                        </div>
                                        <div class="bg-purple-50 rounded-lg p-3">
                                            <p class="text-xs text-purple-600 font-medium mb-1">Opp Score</p>
                                            <p class="text-2xl font-bold text-purple-700">{{ $review->score_team_b }}</p>
                                        </div>
                                    </div>
                                    @if ($review->comment)
                                        <div class="bg-slate-50 rounded-lg p-3">
                                            <p class="text-sm text-slate-600">{{ $review->comment }}</p>
                                        </div>
                                    @endif
                                </div>
                                <form action="{{ route('admin.adjudicator-reviews.destroy', $review) }}" method="POST"
                                    onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 text-red-600 hover:text-red-800 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Add New Review Form -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-slate-900">Add Adjudicator Review</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.adjudicator-reviews.store', $match) }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="adjudicator_id" class="block text-sm font-medium text-slate-700">Adjudicator</label>
                        <select id="adjudicator_id" name="adjudicator_id" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Adjudicator</option>
                            @foreach ($adjudicators as $adj)
                                <option value="{{ $adj->id }}" {{ old('adjudicator_id') == $adj->id ? 'selected' : '' }}>
                                    {{ $adj->name }} - {{ $adj->institution }}
                                    @if ($adj->rating)
                                        (Rating: {{ $adj->rating }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('adjudicator_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="score_team_a" class="block text-sm font-medium text-slate-700">
                                Score for {{ $match->govTeam->name }} (Gov)
                            </label>
                            <input type="number" name="score_team_a" id="score_team_a" value="{{ old('score_team_a') }}"
                                required min="0" max="100" step="0.01"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('score_team_a')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="score_team_b" class="block text-sm font-medium text-slate-700">
                                Score for {{ $match->oppTeam->name }} (Opp)
                            </label>
                            <input type="number" name="score_team_b" id="score_team_b" value="{{ old('score_team_b') }}"
                                required min="0" max="100" step="0.01"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('score_team_b')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="comment" class="block text-sm font-medium text-slate-700">Comment (Optional)</label>
                        <textarea name="comment" id="comment" rows="4"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Feedback on team performance...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-3">
                    <a href="{{ route('admin.matches.index') }}"
                        class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                        Back to Matches
                    </a>
                    <button type="submit"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection