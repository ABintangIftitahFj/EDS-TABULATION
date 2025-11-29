@extends('layouts.admin')

@section('title', 'Matches')

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
            <h1 class="text-2xl font-bold text-black">Matches</h1>
            <p class="text-black">Manage debate matches and pairings</p>
        </div>
        <a href="{{ route('admin.matches.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
            + Create Match
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
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
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $match->adjudicator->name ?? 'TBA' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $match->status === 'finished' ? 'bg-green-100 text-green-800' : ($match->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-black') }}">
                                    {{ ucfirst(str_replace('_', ' ', $match->status ?? 'not started')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.adjudicator-reviews.create', $match) }}"
                                    class="text-green-600 hover:text-green-900 mr-3">Reviews</a>
                                <a href="{{ route('admin.matches.edit', $match) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.matches.destroy', $match) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this match?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-black">
                                No matches found. <a href="{{ route('admin.matches.create') }}"
                                    class="text-indigo-600 hover:text-indigo-500">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($matches->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $matches->links() }}
            </div>
        @endif
    </div>
@endsection