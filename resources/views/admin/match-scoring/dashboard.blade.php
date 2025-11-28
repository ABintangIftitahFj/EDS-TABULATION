@extends('layouts.admin')

@section('title', 'Tournament Dashboard - ' . $tournament->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('admin.match-scoring.show', $tournament) }}" 
                           class="text-blue-600 hover:text-blue-800 transition-colors">
                            ← Back to Match Scoring
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-black flex items-center gap-3">
                        📊 {{ $tournament->name }} - Dashboard
                    </h1>
                    <p class="text-black mt-1">Tournament overview and statistics</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('tournaments.show', $tournament) }}" 
                       target="_blank"
                       class="bg-green-600 hover:bg-green-700 text-black px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                        👀 View Public
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['total_rounds'] }}</p>
                        <p class="text-black">Total Rounds</p>
                    </div>
                    <div class="text-3xl">🔄</div>
                </div>
                <div class="mt-2 text-sm text-green-600">
                    {{ $stats['published_rounds'] }} published
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['total_matches'] }}</p>
                        <p class="text-black">Total Matches</p>
                    </div>
                    <div class="text-3xl">⚔️</div>
                </div>
                <div class="mt-2 text-sm text-green-600">
                    {{ $stats['completed_matches'] }} completed
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-orange-600">{{ $stats['completed_matches'] > 0 ? round(($stats['completed_matches'] / $stats['total_matches']) * 100, 1) : 0 }}%</p>
                        <p class="text-black">Completion Rate</p>
                    </div>
                    <div class="text-3xl">📈</div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-orange-600 h-2 rounded-full" style="width: {{ $stats['completed_matches'] > 0 ? round(($stats['completed_matches'] / $stats['total_matches']) * 100, 1) : 0 }}%"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-purple-600">{{ $tournament->teams_count ?? 0 }}</p>
                        <p class="text-black">Teams Registered</p>
                    </div>
                    <div class="text-3xl">👥</div>
                </div>
                <div class="mt-2 text-sm text-purple-600">
                    {{ ($tournament->teams_count ?? 0) * 2 }} speakers
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-black mb-6 flex items-center gap-2">
                🕒 Recent Match Activity
            </h2>
            
            @if($recentMatches->count() > 0)
            <div class="space-y-4">
                @foreach($recentMatches as $match)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-4">
                        <div class="text-2xl">
                            @if($match->is_completed)
                                ✅
                            @else
                                ⏳
                            @endif
                        </div>
                        <div>
                            <div class="font-medium text-black">
                                {{ $match->room->name ?? 'TBA' }} - {{ $match->round->name }}
                            </div>
                            <div class="text-sm text-black">
                                🏛️ {{ $match->govTeam->name ?? 'TBA' }} vs ⚔️ {{ $match->oppTeam->name ?? 'TBA' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        @if($match->is_completed && $match->winner)
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $match->winner_id === $match->gov_team_id ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                {{ $match->winner_id === $match->gov_team_id ? '🏛️ Gov Win' : '⚔️ Opp Win' }}
                            </div>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @endif
                        <div class="text-xs text-black mt-1">
                            {{ $match->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <div class="text-4xl mb-4">⚔️</div>
                <p class="text-black">No matches found</p>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Tournament Management -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-black mb-6 flex items-center gap-2">
                    ⚙️ Tournament Management
                </h2>
                
                <div class="space-y-4">
                    <a href="{{ route('admin.tournaments.edit', $tournament) }}" 
                       class="flex items-center gap-3 p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200 group">
                        <div class="text-2xl">🏆</div>
                        <div class="flex-1">
                            <div class="font-medium text-blue-900 group-hover:text-blue-800">Edit Tournament</div>
                            <div class="text-sm text-blue-600">Settings, dates, format</div>
                        </div>
                        <div class="text-blue-400">→</div>
                    </a>
                    
                    <a href="{{ route('admin.teams.index') }}?tournament={{ $tournament->id }}" 
                       class="flex items-center gap-3 p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors border border-green-200 group">
                        <div class="text-2xl">👥</div>
                        <div class="flex-1">
                            <div class="font-medium text-green-900 group-hover:text-green-800">Manage Teams</div>
                            <div class="text-sm text-green-600">Registration, speakers</div>
                        </div>
                        <div class="text-green-400">→</div>
                    </a>
                    
                    <a href="{{ route('admin.adjudicators.index') }}?tournament={{ $tournament->id }}" 
                       class="flex items-center gap-3 p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors border border-purple-200 group">
                        <div class="text-2xl">⚖️</div>
                        <div class="flex-1">
                            <div class="font-medium text-purple-900 group-hover:text-purple-800">Manage Adjudicators</div>
                            <div class="text-sm text-purple-600">Panel allocation</div>
                        </div>
                        <div class="text-purple-400">→</div>
                    </a>
                </div>
            </div>

            <!-- Round Management -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-black mb-6 flex items-center gap-2">
                    🔄 Round Management
                </h2>
                
                <div class="space-y-4">
                    <a href="{{ route('admin.rounds.create') }}?tournament={{ $tournament->id }}" 
                       class="flex items-center gap-3 p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors border border-orange-200 group">
                        <div class="text-2xl">➕</div>
                        <div class="flex-1">
                            <div class="font-medium text-orange-900 group-hover:text-orange-800">Create New Round</div>
                            <div class="text-sm text-orange-600">Add another round</div>
                        </div>
                        <div class="text-orange-400">→</div>
                    </a>
                    
                    <a href="{{ route('admin.matches.index') }}?tournament={{ $tournament->id }}" 
                       class="flex items-center gap-3 p-4 bg-teal-50 hover:bg-teal-100 rounded-lg transition-colors border border-teal-200 group">
                        <div class="text-2xl">⚔️</div>
                        <div class="flex-1">
                            <div class="font-medium text-teal-900 group-hover:text-teal-800">View All Matches</div>
                            <div class="text-sm text-teal-600">Match overview</div>
                        </div>
                        <div class="text-teal-400">→</div>
                    </a>
                    
                    <a href="{{ route('admin.ballots.index') }}?tournament={{ $tournament->id }}" 
                       class="flex items-center gap-3 p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors border border-indigo-200 group">
                        <div class="text-2xl">📋</div>
                        <div class="flex-1">
                            <div class="font-medium text-indigo-900 group-hover:text-indigo-800">View Ballots</div>
                            <div class="text-sm text-indigo-600">Scoring history</div>
                        </div>
                        <div class="text-indigo-400">→</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
