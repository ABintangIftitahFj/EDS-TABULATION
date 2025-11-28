@extends('layouts.admin')

@section('title', 'Tournament Match Scoring')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-black flex items-center gap-3">
                        🏆 Tournament Match Scoring
                    </h1>
                    <p class="text-black mt-2">Select a tournament to manage matches and scoring</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-black px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                        🏠 Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Tournament Selection -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-black mb-4 flex items-center gap-2">
                🎯 Select Tournament
            </h2>
            
            <!-- Search and Filter -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text" 
                           id="tournamentSearch" 
                           placeholder="Search tournaments..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tournament Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="tournamentGrid">
                @forelse($tournaments as $tournament)
                <div class="tournament-card bg-gradient-to-br from-white to-blue-50 rounded-xl border-2 border-gray-200 hover:border-blue-300 transition-all hover:shadow-xl cursor-pointer p-6"
                     data-name="{{ strtolower($tournament->name) }}"
                     onclick="selectTournament({{ $tournament->id }}, '{{ $tournament->name }}')">
                    
                    <!-- Tournament Info -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-black mb-1">{{ $tournament->name }}</h3>
                            <div class="text-sm text-black space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-blue-600">📅</span>
                                    {{ $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('M j, Y') : 'TBD' }}
                                </div>
                                @if($tournament->end_date && $tournament->start_date !== $tournament->end_date)
                                <div class="flex items-center gap-2">
                                    <span class="text-blue-600">📅</span>
                                    to {{ \Carbon\Carbon::parse($tournament->end_date)->format('M j, Y') }}
                                </div>
                                @endif
                                @if($tournament->location)
                                <div class="flex items-center gap-2">
                                    <span class="text-blue-600">📍</span>
                                    {{ $tournament->location }}
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="ml-4">
                            @php
                                $statusClass = match($tournament->status ?? 'upcoming') {
                                    'active' => 'bg-green-100 text-green-800 border-green-200',
                                    'completed' => 'bg-gray-100 text-black border-gray-200',
                                    default => 'bg-blue-100 text-blue-800 border-blue-200'
                                };
                                $statusEmoji = match($tournament->status ?? 'upcoming') {
                                    'active' => '🟢',
                                    'completed' => '🏁',
                                    default => '🔵'
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                                {{ $statusEmoji }} {{ ucfirst($tournament->status ?? 'Upcoming') }}
                            </span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $tournament->teams_count ?? 0 }}</div>
                            <div class="text-xs text-black">Teams</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $tournament->rounds_count ?? 0 }}</div>
                            <div class="text-xs text-black">Rounds</div>
                        </div>
                    </div>

                    <!-- Action Hint -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="text-center text-sm text-blue-600 font-medium">
                            Click to manage matches →
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4">🎯</div>
                    <h3 class="text-xl font-semibold text-black mb-2">No Tournaments Found</h3>
                    <p class="text-black mb-6">Create a tournament first to start managing matches and scoring.</p>
                    <a href="{{ route('admin.tournaments.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-black px-6 py-3 rounded-lg transition-colors font-medium">
                        Create Tournament
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        @if($tournaments->count() > 0)
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-black mb-4 flex items-center gap-2">
                ⚡ Quick Actions
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.tournaments.index') }}" 
                   class="flex items-center gap-3 p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200">
                    <div class="text-2xl">🏆</div>
                    <div>
                        <div class="font-medium text-blue-900">Manage Tournaments</div>
                        <div class="text-sm text-blue-600">Edit settings</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.teams.index') }}" 
                   class="flex items-center gap-3 p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors border border-green-200">
                    <div class="text-2xl">👥</div>
                    <div>
                        <div class="font-medium text-green-900">Teams & Speakers</div>
                        <div class="text-sm text-green-600">Registration</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.adjudicators.index') }}" 
                   class="flex items-center gap-3 p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors border border-purple-200">
                    <div class="text-2xl">⚖️</div>
                    <div>
                        <div class="font-medium text-purple-900">Adjudicators</div>
                        <div class="text-sm text-purple-600">Panel management</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.rounds.index') }}" 
                   class="flex items-center gap-3 p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors border border-orange-200">
                    <div class="text-2xl">🔄</div>
                    <div>
                        <div class="font-medium text-orange-900">Rounds</div>
                        <div class="text-sm text-orange-600">Create & manage</div>
                    </div>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- JavaScript for Search and Selection -->
<script>
function selectTournament(tournamentId, tournamentName) {
    window.location.href = `{{ route('admin.match-scoring.show', '') }}/${tournamentId}`;
}

// Search functionality
document.getElementById('tournamentSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.tournament-card');
    
    cards.forEach(card => {
        const name = card.getAttribute('data-name');
        if (name.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Add hover effects
document.querySelectorAll('.tournament-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});
</script>
@endsection
