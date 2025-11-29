@extends('layouts.admin')

@section('title', 'Enter Ballot')

@section('content')
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">📝 Input Ballot</h1>
                    <p class="text-gray-600 mt-1">{{ $match->round->tournament->name }} - {{ $match->round->name }}</p>
                </div>
                <span class="px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full font-semibold text-sm">
                    {{ strtoupper($match->round->tournament->format) }}
                </span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mt-4 p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Room</p>
                    <p class="font-semibold text-gray-900">🏛️ {{ $match->room->name ?? 'TBA' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Adjudicator</p>
                    <p class="font-semibold text-gray-900">⚖️ {{ $match->adjudicator->name ?? 'TBA' }}</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.ballots.store', $match->id) }}" method="POST" id="ballotForm">
            @csrf

            @if($match->round->tournament->format === 'british')
                {{-- BRITISH PARLIAMENTARY FORMAT --}}
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Team Rankings
                    </h2>
                    <p class="text-gray-600 mb-6">Assign ranks 1-4 to each team (1 = Winner, 4 = Last Place)</p>

                    <div class="space-y-4">
                        {{-- Opening Government --}}
                        <div class="flex items-center gap-4 p-5 bg-blue-50 rounded-lg border-2 border-blue-300 hover:shadow-md transition">
                            <div class="flex-1">
                                <p class="font-bold text-lg text-gray-900">{{ $match->govTeam->name }}</p>
                                <p class="text-sm text-blue-700 font-medium">Opening Government (OG)</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-gray-700">Rank:</label>
                                <select name="ranks[{{ $match->gov_team_id }}]" 
                                        required
                                        class="w-24 px-4 py-2.5 text-lg font-bold text-center border-2 border-blue-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-</option>
                                    <option value="1">1st</option>
                                    <option value="2">2nd</option>
                                    <option value="3">3rd</option>
                                    <option value="4">4th</option>
                                </select>
                            </div>
                        </div>

                        {{-- Opening Opposition --}}
                        <div class="flex items-center gap-4 p-5 bg-red-50 rounded-lg border-2 border-red-300 hover:shadow-md transition">
                            <div class="flex-1">
                                <p class="font-bold text-lg text-gray-900">{{ $match->oppTeam->name }}</p>
                                <p class="text-sm text-red-700 font-medium">Opening Opposition (OO)</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-gray-700">Rank:</label>
                                <select name="ranks[{{ $match->opp_team_id }}]" 
                                        required
                                        class="w-24 px-4 py-2.5 text-lg font-bold text-center border-2 border-red-400 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="">-</option>
                                    <option value="1">1st</option>
                                    <option value="2">2nd</option>
                                    <option value="3">3rd</option>
                                    <option value="4">4th</option>
                                </select>
                            </div>
                        </div>

                        {{-- Closing Government --}}
                        <div class="flex items-center gap-4 p-5 bg-green-50 rounded-lg border-2 border-green-300 hover:shadow-md transition">
                            <div class="flex-1">
                                <p class="font-bold text-lg text-gray-900">{{ $match->cgTeam->name }}</p>
                                <p class="text-sm text-green-700 font-medium">Closing Government (CG)</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-gray-700">Rank:</label>
                                <select name="ranks[{{ $match->cg_team_id }}]" 
                                        required
                                        class="w-24 px-4 py-2.5 text-lg font-bold text-center border-2 border-green-400 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">-</option>
                                    <option value="1">1st</option>
                                    <option value="2">2nd</option>
                                    <option value="3">3rd</option>
                                    <option value="4">4th</option>
                                </select>
                            </div>
                        </div>

                        {{-- Closing Opposition --}}
                        <div class="flex items-center gap-4 p-5 bg-orange-50 rounded-lg border-2 border-orange-300 hover:shadow-md transition">
                            <div class="flex-1">
                                <p class="font-bold text-lg text-gray-900">{{ $match->coTeam->name }}</p>
                                <p class="text-sm text-orange-700 font-medium">Closing Opposition (CO)</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-gray-700">Rank:</label>
                                <select name="ranks[{{ $match->co_team_id }}]" 
                                        required
                                        class="w-24 px-4 py-2.5 text-lg font-bold text-center border-2 border-orange-400 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                    <option value="">-</option>
                                    <option value="1">1st</option>
                                    <option value="2">2nd</option>
                                    <option value="3">3rd</option>
                                    <option value="4">4th</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Validation Helper --}}
                    <div class="mt-6 p-4 bg-yellow-50 border-2 border-yellow-300 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <strong>⚠️ Important:</strong> Each rank (1, 2, 3, 4) must be assigned to exactly one team. No duplicates allowed.
                        </p>
                    </div>
                </div>

            @else
                {{-- ASIAN PARLIAMENTARY FORMAT --}}
                <div class="space-y-6">
                    {{-- Government Team --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Government: {{ $match->govTeam->name }}
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach($match->govTeam->speakers as $index => $speaker)
                                <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-lg border-2 border-blue-200">
                                    <div class="flex-shrink-0 w-24">
                                        <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full font-bold">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $speaker->name }}</p>
                                        <p class="text-sm text-gray-600">Speaker {{ $index + 1 }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <label class="text-sm font-medium text-gray-700">Score:</label>
                                        <input type="number" 
                                               name="scores[{{ $speaker->id }}]" 
                                               min="60" 
                                               max="100" 
                                               step="0.5"
                                               required
                                               class="w-24 px-4 py-2 text-lg font-bold text-center border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="75">
                                        <span class="text-sm text-gray-500">/100</span>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Government Reply Score (Optional) --}}
                            <div class="mt-4 p-4 bg-blue-100 rounded-lg border-2 border-blue-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">Reply Speaker (Optional)</p>
                                        <p class="text-sm text-gray-600">Leave blank if no reply</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <label class="text-sm font-medium text-gray-700">Score:</label>
                                        <input type="number" 
                                               name="reply_scores[{{ $match->gov_team_id }}]" 
                                               min="35" 
                                               max="50" 
                                               step="0.5"
                                               class="w-24 px-4 py-2 text-lg font-bold text-center border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="40">
                                        <span class="text-sm text-gray-500">/50</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Opposition Team --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-red-600 to-red-700 p-4">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Opposition: {{ $match->oppTeam->name }}
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach($match->oppTeam->speakers as $index => $speaker)
                                <div class="flex items-center gap-4 p-4 bg-red-50 rounded-lg border-2 border-red-200">
                                    <div class="flex-shrink-0 w-24">
                                        <span class="inline-flex items-center justify-center w-10 h-10 bg-red-600 text-white rounded-full font-bold">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $speaker->name }}</p>
                                        <p class="text-sm text-gray-600">Speaker {{ $index + 1 }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <label class="text-sm font-medium text-gray-700">Score:</label>
                                        <input type="number" 
                                               name="scores[{{ $speaker->id }}]" 
                                               min="60" 
                                               max="100" 
                                               step="0.5"
                                               required
                                               class="w-24 px-4 py-2 text-lg font-bold text-center border-2 border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                               placeholder="75">
                                        <span class="text-sm text-gray-500">/100</span>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Opposition Reply Score (Optional) --}}
                            <div class="mt-4 p-4 bg-red-100 rounded-lg border-2 border-red-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">Reply Speaker (Optional)</p>
                                        <p class="text-sm text-gray-600">Leave blank if no reply</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <label class="text-sm font-medium text-gray-700">Score:</label>
                                        <input type="number" 
                                               name="reply_scores[{{ $match->opp_team_id }}]" 
                                               min="35" 
                                               max="50" 
                                               step="0.5"
                                               class="w-24 px-4 py-2 text-lg font-bold text-center border-2 border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                               placeholder="40">
                                        <span class="text-sm text-gray-500">/50</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Winner Selection (Manual Override) --}}
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">🏆 Winner Selection</h3>
                        <p class="text-sm text-gray-600 mb-4">Winner will be auto-calculated based on total scores. You can manually override if needed.</p>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="winner_id" value="{{ $match->gov_team_id }}" class="peer sr-only">
                                <div class="p-4 border-2 border-gray-300 rounded-lg peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-blue-400 transition">
                                    <p class="font-semibold text-gray-900 text-center">{{ $match->govTeam->name }}</p>
                                    <p class="text-sm text-gray-600 text-center">Government</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="winner_id" value="{{ $match->opp_team_id }}" class="peer sr-only">
                                <div class="p-4 border-2 border-gray-300 rounded-lg peer-checked:border-red-600 peer-checked:bg-red-50 hover:border-red-400 transition">
                                    <p class="font-semibold text-gray-900 text-center">{{ $match->oppTeam->name }}</p>
                                    <p class="text-sm text-gray-600 text-center">Opposition</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="winner_id" value="" class="peer sr-only" checked>
                                <div class="p-4 border-2 border-gray-300 rounded-lg peer-checked:border-gray-600 peer-checked:bg-gray-50 hover:border-gray-400 transition">
                                    <p class="font-semibold text-gray-900 text-center">Auto Calculate</p>
                                    <p class="text-sm text-gray-600 text-center">Based on scores</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Submit Buttons --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all text-lg">
                        ✅ Submit Ballot
                    </button>
                    <button type="button" 
                            onclick="window.history.back()"
                            class="px-6 py-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Validation for British Parliamentary (no duplicate ranks)
        @if($match->round->tournament->format === 'british')
        document.getElementById('ballotForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const rankSelects = document.querySelectorAll('select[name^="ranks"]');
            const ranks = [];
            let valid = true;
            let errorMsg = '';

            rankSelects.forEach(select => {
                const value = select.value;
                if (!value) {
                    valid = false;
                    errorMsg = 'Please assign ranks to all teams!';
                    return;
                }
                if (ranks.includes(value)) {
                    valid = false;
                    errorMsg = `Rank ${value} is assigned to multiple teams. Each rank must be unique!`;
                    return;
                }
                ranks.push(value);
            });

            if (!valid) {
                Swal.fire({
                    title: 'Invalid Ranking!',
                    text: errorMsg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#DC2626'
                });
                return false;
            }

            // Show confirmation
            Swal.fire({
                title: 'Submit Ballot?',
                text: 'Are you sure the rankings are correct?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit! 🎯',
                cancelButtonText: 'Review Again',
                confirmButtonColor: '#16A34A',
                cancelButtonColor: '#6B7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Submitting...',
                        html: 'Saving ballot... ⚡',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    this.submit();
                }
            });
        });
        @else
        // Validation for Asian Parliamentary
        document.getElementById('ballotForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Submit Ballot?',
                text: 'Make sure all scores are correct!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit! 🎯',
                cancelButtonText: 'Review Scores',
                confirmButtonColor: '#16A34A',
                cancelButtonColor: '#6B7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Submitting...',
                        html: 'Calculating results... ⚡',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    this.submit();
                }
            });
        });
        @endif
    </script>
    @endpush
@endsection