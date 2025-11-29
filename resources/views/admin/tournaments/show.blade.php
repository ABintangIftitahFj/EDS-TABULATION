@extends('layouts.admin')

@section('title', $tournament->name)

@section('content')
    <!-- Admin Home Button -->
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-300 rounded-md hover:bg-indigo-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            🏠 Admin Home
        </a>
    </div>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-black">{{ $tournament->name }}</h1>
                <p class="text-black mt-1">{{ $tournament->format }} • {{ $tournament->location }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.tournaments.edit', $tournament) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-black hover:bg-slate-50">
                    Edit Tournament
                </a>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $tournament->status === 'ongoing' ? 'bg-green-100 text-green-800' : ($tournament->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-black') }}">
                    {{ ucfirst($tournament->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-black border-2 border-blue-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-50 text-sm font-medium uppercase tracking-wide">Teams</p>
                    <p class="text-4xl font-bold mt-2">{{ $tournament->teams->count() }}</p>
                </div>
                <div class="bg-blue-700 rounded-lg p-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-purple-600 rounded-xl shadow-lg p-6 text-black border-2 border-purple-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-50 text-sm font-medium uppercase tracking-wide">Adjudicators</p>
                    <p class="text-4xl font-bold mt-2">{{ $tournament->adjudicators->count() }}</p>
                </div>
                <div class="bg-purple-700 rounded-lg p-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-green-600 rounded-xl shadow-lg p-6 text-black border-2 border-green-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-50 text-sm font-medium uppercase tracking-wide">Rounds</p>
                    <p class="text-4xl font-bold mt-2">{{ $tournament->rounds->count() }}</p>
                </div>
                <div class="bg-green-700 rounded-lg p-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-orange-600 rounded-xl shadow-lg p-6 text-black border-2 border-orange-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-50 text-sm font-medium uppercase tracking-wide">Speakers</p>
                    <p class="text-4xl font-bold mt-2">{{ $tournament->teams->sum(fn($t) => $t->speakers->count()) }}</p>
                </div>
                <div class="bg-orange-700 rounded-lg p-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('admin.tournaments.import', $tournament) }}"
            class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Import Data</h3>
                    <p class="text-sm text-black">Upload CSV files</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.rounds.create') }}?tournament_id={{ $tournament->id }}"
            class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Create Round</h3>
                    <p class="text-sm text-black">Add new round</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.matches.create') }}?tournament_id={{ $tournament->id }}"
            class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-purple-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Create Match</h3>
                    <p class="text-sm text-black">Generate pairings</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Tabs Content -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="border-b border-slate-200">
            <nav class="flex -mb-px">
                <button
                    class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-indigo-600 text-indigo-600"
                    data-tab="teams">
                    Teams
                </button>
                <button class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-black"
                    data-tab="adjudicators">
                    Adjudicators
                </button>
                <button class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-black"
                    data-tab="rounds">
                    Rounds
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Teams Tab -->
            <div id="teams-tab" class="tab-content">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Team</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Institution
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Speakers</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($tournament->teams as $team)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-black">{{ $team->name }}</td>
                                    <td class="px-4 py-3 text-sm text-black">{{ $team->institution }}</td>
                                    <td class="px-4 py-3 text-sm text-black">
                                        {{ $team->speakers->pluck('name')->join(', ') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-black">No teams yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Adjudicators Tab -->
            <div id="adjudicators-tab" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Institution
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($tournament->adjudicators as $adj)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-black">{{ $adj->name }}</td>
                                    <td class="px-4 py-3 text-sm text-black">{{ $adj->institution }}</td>
                                    <td class="px-4 py-3 text-sm text-black">{{ $adj->rating ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-black">No adjudicators yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rounds Tab -->
            <div id="rounds-tab" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Round</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Motion</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($tournament->rounds as $round)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-black">{{ $round->name }}</td>
                                    <td class="px-4 py-3 text-sm text-black">{{ $round->motion ?? 'TBA' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-8 text-center text-black">No rounds yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.dataset.tab;

                // Update buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('border-indigo-600', 'text-indigo-600', 'active');
                    btn.classList.add('border-transparent', 'text-black');
                });
                button.classList.add('border-indigo-600', 'text-indigo-600', 'active');
                button.classList.remove('border-transparent', 'text-black');

                // Update content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(`${tabName}-tab`).classList.remove('hidden');
            });
        });
    </script>
@endpush
