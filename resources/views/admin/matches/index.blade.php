@extends('layouts.admin')

@section('title', 'Matches')

@section('content')
    <!-- Admin Home Button -->
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-300 rounded-md hover:bg-indigo-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            🏠 Admin Home
        </a>
    </div>

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-black">Matches</h1>
            <p class="text-black">Manage debate matches and pairings</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <button onclick="openAutoGenerateModal()"
                class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                ⚡ Auto Generate Draw
            </button>
            <a href="{{ route('admin.matches.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
                + Create Match
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-slate-200">
        <form action="{{ route('admin.matches.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label for="tournament_id" class="block text-sm font-medium text-gray-700 mb-1">Tournament</label>
                <select name="tournament_id" id="tournament_id"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    onchange="this.form.submit()">
                    <option value="">All Tournaments</option>
                    @foreach(\App\Models\Tournament::orderBy('created_at', 'desc')->get() as $tournament)
                        <option value="{{ $tournament->id }}" {{ request('tournament_id') == $tournament->id ? 'selected' : '' }}>
                            {{ $tournament->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label for="round_id" class="block text-sm font-medium text-gray-700 mb-1">Round</label>
                <select name="round_id" id="round_id"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    onchange="this.form.submit()">
                    <option value="">All Rounds</option>
                    @if(request('tournament_id'))
                        @foreach(\App\Models\Round::where('tournament_id', request('tournament_id'))->orderBy('created_at', 'desc')->get() as $round)
                            <option value="{{ $round->id }}" {{ request('round_id') == $round->id ? 'selected' : '' }}>
                                {{ $round->name }}
                            </option>
                        @endforeach
                    @else
                        @foreach(\App\Models\Round::orderBy('created_at', 'desc')->take(20)->get() as $round)
                            <option value="{{ $round->id }}" {{ request('round_id') == $round->id ? 'selected' : '' }}>
                                {{ $round->tournament->name }} - {{ $round->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="w-full md:w-auto">
                <a href="{{ route('admin.matches.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mobile View (Cards) -->
    <div class="md:hidden space-y-4 mb-6">
        @forelse($matches as $match)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <!-- Match Header -->
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <div class="font-semibold text-black">{{ $match->round->tournament->name ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-500">{{ $match->round->name ?? 'N/A' }}</div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ ($match->result_status ?? '') === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($match->result_status ?? 'Scheduled') }}
                    </span>
                </div>
                
                <!-- Match Info -->
                <div class="bg-slate-50 rounded-lg p-3 mb-3">
                    <div class="text-xs font-medium text-gray-500 mb-2">
                        📍 {{ $match->room->name ?? 'Room TBA' }} • 👨‍⚖️ {{ $match->adjudicator->name ?? 'Adj TBA' }}
                    </div>
                    
                    <!-- Teams Display -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-blue-600">Gov</span>
                            <span class="font-semibold text-black text-sm">{{ $match->govTeam->emoji ?? '' }} {{ $match->govTeam->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-purple-600">Opp</span>
                            <span class="font-semibold text-black text-sm">{{ $match->oppTeam->emoji ?? '' }} {{ $match->oppTeam->name ?? 'N/A' }}</span>
                        </div>
                        @if($match->cgTeam)
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-green-600">CG</span>
                                <span class="font-semibold text-black text-sm">{{ $match->cgTeam->emoji ?? '' }} {{ $match->cgTeam->name ?? 'N/A' }}</span>
                            </div>
                        @endif
                        @if($match->coTeam)
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-orange-600">CO</span>
                                <span class="font-semibold text-black text-sm">{{ $match->coTeam->emoji ?? '' }} {{ $match->coTeam->name ?? 'N/A' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="grid grid-cols-3 gap-2">
                    <button onclick="openScoreModal('{{ route('admin.ballots.create', $match->id) }}')"
                        class="w-full px-3 py-2.5 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 transition-colors flex items-center justify-center gap-1">
                        📝 Score
                    </button>
                    <a href="{{ route('admin.matches.edit', $match->id) }}"
                        class="w-full px-3 py-2.5 bg-white border border-gray-300 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-50 transition-colors text-center flex items-center justify-center gap-1">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST" class="w-full"
                        onsubmit="return confirm('Delete this match?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-3 py-2.5 bg-red-100 text-red-700 text-xs font-medium rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center gap-1">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center text-gray-500">
                No matches found. Try selecting a tournament and round.
            </div>
        @endforelse
        
        <!-- Mobile Pagination -->
        @if($matches->hasPages())
            <div class="mt-4">
                {{ $matches->links() }}
            </div>
        @endif
    </div>

    <!-- Desktop View (Table) -->
    <div class="hidden md:block bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <div class="overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
                <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Round
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Room
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Teams
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Adjudicator
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Status
                        </th>
                        <th class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($matches as $match)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-black">
                                    {{ $match->round->tournament->name ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-black">{{ $match->round->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $match->room->name ?? 'TBA' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-black">
                                    <div><span class="font-semibold text-blue-600">Gov:</span>
                                        {{ $match->govTeam->emoji ?? '' }} {{ $match->govTeam->name ?? 'N/A' }}</div>
                                    <div><span class="font-semibold text-purple-600">Opp:</span>
                                        {{ $match->oppTeam->emoji ?? '' }} {{ $match->oppTeam->name ?? 'N/A' }}</div>
                                    @if($match->cgTeam)
                                        <div><span class="font-semibold text-green-600">CG:</span>
                                            {{ $match->cgTeam->emoji ?? '' }} {{ $match->cgTeam->name ?? 'N/A' }}</div>
                                    @endif
                                    @if($match->coTeam)
                                        <div><span class="font-semibold text-orange-600">CO:</span>
                                            {{ $match->coTeam->emoji ?? '' }} {{ $match->coTeam->name ?? 'N/A' }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $match->adjudicator->name ?? 'TBA' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ ($match->result_status ?? '') === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($match->result_status ?? 'Scheduled') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <button onclick="openScoreModal('{{ route('admin.ballots.create', $match->id) }}')"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                        Input Score
                                    </button>
                                    <a href="{{ route('admin.matches.edit', $match->id) }}"
                                        class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this match?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="text-4xl mb-2">🎯</div>
                                <div class="font-medium">No matches found</div>
                                <div class="text-sm">Try selecting a tournament and round to see matches.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </div>
        
        <!-- Desktop Pagination -->
        @if($matches->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $matches->links() }}
            </div>
        @endif
    </div>

    <!-- Auto Generate Modal -->
    <div id="autoGenerateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeAutoGenerateModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('admin.matches.auto-generate') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Auto Generate Draw
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Select a round to automatically generate matches for. This will shuffle teams and
                                        assign them to rooms and adjudicators.
                                    </p>
                                    <div>
                                        <label for="auto_round_id"
                                            class="block text-sm font-medium text-gray-700">Round</label>
                                        <select id="auto_round_id" name="round_id" required
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="">Select a round</option>
                                            @foreach($rounds as $round)
                                                <option value="{{ $round->id }}">{{ $round->tournament->name }} -
                                                    {{ $round->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Generate
                        </button>
                        <button type="button" onclick="closeAutoGenerateModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Score Modal -->
    <div id="scoreModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeScoreModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full h-[80vh]">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 h-full flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Enter Ballot</h3>
                        <button onclick="closeScoreModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <iframe id="scoreFrame" src="" class="w-full flex-1 border-0"></iframe>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openAutoGenerateModal() {
                document.getElementById('autoGenerateModal').classList.remove('hidden');
            }

            function closeAutoGenerateModal() {
                document.getElementById('autoGenerateModal').classList.add('hidden');
            }

            function openScoreModal(url) {
                document.getElementById('scoreFrame').src = url;
                document.getElementById('scoreModal').classList.remove('hidden');
            }

            function closeScoreModal() {
                document.getElementById('scoreModal').classList.add('hidden');
                document.getElementById('scoreFrame').src = '';
            }
        </script>
    @endpush
@endsection