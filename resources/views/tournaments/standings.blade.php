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
                                            <button onclick="showTeamHistory({{ $team->id }}, '{{ $team->name }}')" 
                                                class="text-base font-bold text-black font-sans hover:text-england-blue hover:underline cursor-pointer transition-colors">
                                                {{ $team->emoji ?? '👥' }} {{ $team->name }}
                                            </button>
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
                                        {{ $speaker->average_score ?? '0.00' }}
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

    <!-- Team History Modal -->
    <div id="teamHistoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeTeamHistory()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full w-full">
                <div class="bg-gradient-to-r from-england-blue to-england-red px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-pixel text-white" id="teamHistoryTitle">
                            🔥 GEBRAKAN TIM
                        </h3>
                        <button onclick="closeTeamHistory()" class="text-white hover:text-gray-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="bg-white px-6 py-6" id="teamHistoryContent">
                    <div class="flex justify-center items-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-england-blue"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        async function showTeamHistory(teamId, teamName) {
            const modal = document.getElementById('teamHistoryModal');
            const title = document.getElementById('teamHistoryTitle');
            const content = document.getElementById('teamHistoryContent');

            // Show modal with loading
            title.innerHTML = `🔥 GEBRAKAN: ${teamName}`;
            content.innerHTML = `
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-england-blue"></div>
                </div>
            `;
            modal.classList.remove('hidden');

            try {
                const response = await fetch(`/api/teams/${teamId}/match-history`);
                const data = await response.json();

                if (!data.success) {
                    throw new Error('Failed to fetch team history');
                }

                if (data.matches.length === 0) {
                    content.innerHTML = `
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🤷</div>
                            <p class="text-lg font-pixel text-slate-600">Belum ada pertandingan</p>
                        </div>
                    `;
                    return;
                }

                let html = `
                    <div class="mb-4 p-4 bg-gradient-to-r from-purple-100 to-blue-100 rounded-lg border-2 border-indigo-900">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-600 font-pixel">Total Pertandingan</p>
                                <p class="text-3xl font-pixel text-england-blue">${data.total_matches}</p>
                            </div>
                            <div class="text-5xl">${data.team.emoji}</div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-slate-900">
                            <thead class="bg-england-red text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-pixel border-r-2 border-white/20">Round</th>
                                    <th class="px-4 py-3 text-left text-sm font-pixel border-r-2 border-white/20">Posisi</th>
                                    <th class="px-4 py-3 text-left text-sm font-pixel border-r-2 border-white/20">Lawan</th>
                                    <th class="px-4 py-3 text-left text-sm font-pixel border-r-2 border-white/20">Adjudicator</th>
                                    <th class="px-4 py-3 text-left text-sm font-pixel border-r-2 border-white/20">Result</th>
                                    <th class="px-4 py-3 text-left text-sm font-pixel">Score</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                `;

                data.matches.forEach((match, index) => {
                    const rowBg = index % 2 === 0 ? 'bg-white' : 'bg-slate-50';
                    const scoreDisplay = match.team_score ? match.team_score : '-';
                    
                    html += `
                        <tr class="${rowBg} hover:bg-soft-pink/20 transition-colors">
                            <td class="px-4 py-3 text-sm font-sans border-r border-slate-200">
                                <span class="font-bold">${match.round_name}</span>
                                <br><span class="text-xs text-slate-600">📍 ${match.room_name}</span>
                            </td>
                            <td class="px-4 py-3 text-sm font-pixel border-r border-slate-200">
                                ${match.position === 'Government' ? '🏛️' : '⚔️'} ${match.position}
                            </td>
                            <td class="px-4 py-3 text-sm font-sans border-r border-slate-200">
                                ${match.opponents || 'TBA'}
                            </td>
                            <td class="px-4 py-3 text-sm font-sans border-r border-slate-200">
                                ${match.adjudicator}
                            </td>
                            <td class="px-4 py-3 text-sm font-pixel border-r border-slate-200">
                                ${match.result}
                            </td>
                            <td class="px-4 py-3 text-sm font-bold font-mono">
                                ${scoreDisplay}
                            </td>
                        </tr>
                    `;
                });

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                content.innerHTML = html;

            } catch (error) {
                console.error('Error fetching team history:', error);
                content.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">❌</div>
                        <p class="text-lg font-pixel text-red-600">Gagal memuat data</p>
                    </div>
                `;
            }
        }

        function closeTeamHistory() {
            document.getElementById('teamHistoryModal').classList.add('hidden');
        }
    </script>
@endsection