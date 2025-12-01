@extends('layouts.admin')

@section('title', 'Speakers')

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

    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-black">🎤 Speakers</h1>
            <p class="text-black">View all speakers from teams</p>
        </div>
    </div>

    <!-- Tournament Filter -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <form method="GET" action="{{ route('admin.speakers.index') }}" class="flex items-center gap-4">
            <div class="flex-1 max-w-xs">
                <label for="tournament_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Tournament:</label>
                <select id="tournament_id" name="tournament_id" onchange="this.form.submit()"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Tournaments</option>
                    @foreach($tournaments as $tournament)
                        <option value="{{ $tournament->id }}" {{ $tournamentFilter == $tournament->id ? 'selected' : '' }}>
                            {{ $tournament->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if($tournamentFilter)
                <a href="{{ route('admin.speakers.index') }}" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900">
                    Clear Filter
                </a>
            @endif
        </form>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @forelse($speakers as $speaker)
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <div class="font-semibold text-black text-lg">{{ $speaker->name }}</div>
                        <div class="text-sm text-gray-500">{{ $speaker->team->name ?? 'No Team' }}</div>
                    </div>
                    <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                        {{ $speaker->total_score ?? 0 }} pts
                    </span>
                </div>
                <div class="text-xs text-gray-500 mb-2">
                    🏫 {{ $speaker->team->institution ?? 'N/A' }}
                </div>
                <div class="text-xs text-gray-500">
                    🏆 {{ $speaker->team->tournament->name ?? 'N/A' }}
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-8 text-center">
                <div class="text-4xl mb-2">🎤</div>
                <p class="text-gray-500">No speakers found.</p>
            </div>
        @endforelse
        
        @if ($speakers->hasPages())
            <div class="mt-4">{{ $speakers->links() }}</div>
        @endif
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Speaker Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Team</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Institution</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Tournament</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Total Score</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($speakers as $speaker)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-black">{{ $speaker->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $speaker->team->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $speaker->team->institution ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $speaker->team->tournament->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-black">{{ $speaker->total_score ?? 0 }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-black">
                                No speakers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($speakers->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $speakers->links() }}
            </div>
        @endif
    </div>
@endsection
