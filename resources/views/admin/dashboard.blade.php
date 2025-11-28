@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-500">Total Tournaments</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['total_tournaments'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-500">Total Teams</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['total_teams'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-500">Total Adjudicators</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['total_adjudicators'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-amber-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-500">Active Tournament</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['active_tournament'] ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Tournaments -->
    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
    <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-slate-900">🏆 Active Tournaments</h3>

    <a href="{{ route('admin.tournaments.create') }}"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        New Tournament
    </a>
    </div>
    <div class="p-6">
        @if ($stats['active_tournament'])
            <div class="space-y-4">
                @foreach (\App\Models\Tournament::where('status', 'ongoing')->get() as $tournament)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="bg-indigo-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">{{ $tournament->name }}</h4>
                                <p class="text-sm text-slate-500">
                                    {{ ucfirst(str_replace('_', ' ', $tournament->format)) }} •
                                    {{ $tournament->start_date ? $tournament->start_date->format('M d, Y') : 'Date TBA' }}
                                    • {{ $tournament->location }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.tournaments.show', $tournament) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                            Manage
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-slate-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <p class="text-slate-500 mb-4 text-lg">No ongoing tournaments</p>
                <a href="{{ route('admin.tournaments.create') }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
                    Create your first tournament
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
    </div>

    <!-- All Tournaments -->
    <div class="mt-8 bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-slate-900">All Tournaments</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Tournament
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Format
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse(\App\Models\Tournament::orderBy('created_at', 'desc')->take(10)->get() as $tournament)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-900">{{ $tournament->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-500">{{ ucfirst(str_replace('_', ' ', $tournament->format)) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-500">
                                    {{ $tournament->start_date ? $tournament->start_date->format('M d, Y') : 'TBA' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $tournament->status === 'ongoing' ? 'bg-green-100 text-green-800' : ($tournament->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800') }}">
                                    {{ ucfirst($tournament->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.tournaments.show', $tournament) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                <a href="{{ route('admin.tournaments.edit', $tournament) }}"
                                    class="text-slate-600 hover:text-slate-900">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                No tournaments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            <a href="{{ route('admin.tournaments.index') }}"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                View all tournaments →
            </a>
        </div>
    </div>
@endsection