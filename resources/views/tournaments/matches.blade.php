@extends('layouts.user')

@section('title', 'Matches - ' . $tournament->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold leading-tight text-purple-700">
                ⚔️ {{ $tournament->name }}
            </h1>
        </div>

        {{-- Tabs Navigation --}}
        <div class="border-b border-slate-200 mb-8">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="/tournaments"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    ← All Tournaments
                </a>
                <a href="/tournaments/{{ $tournament->id }}"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🏠 Overview
                </a>
                <a href="/tournaments/{{ $tournament->id }}/standings"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🏆 Standings
                </a>
                <a href="/tournaments/{{ $tournament->id }}/matches"
                    class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium"
                    aria-current="page">
                    ⚔️ Matches & Draw
                </a>
                <a href="/tournaments/{{ $tournament->id }}/results"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    📊 Results
                </a>
                <a href="/tournaments/{{ $tournament->id }}/speakers"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    🎤 Speakers
                </a>
                <a href="/tournaments/{{ $tournament->id }}/motions"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    💡 Motions
                </a>
            </nav>
        </div>

        <div class="space-y-6"
            x-data="{ selectedRound: '{{ $tournament->rounds->sortBy('created_at')->first()->id ?? '' }}' }">

            {{-- Header & Dropdown Selection --}}
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div>
                    <h3 class="text-lg font-medium text-black">Match List</h3>
                    <p class="text-sm text-black">Pilih ronde untuk melihat jadwal pertandingan.</p>
                </div>

                <div class="w-full sm:w-64">
                    @if($tournament->rounds->count() > 0)
                        <select x-model="selectedRound"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach($tournament->rounds->sortBy('created_at') as $round)
                                <option value="{{ $round->id }}">
                                    {{ $round->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <span class="text-sm text-red-500">Belum ada ronde dibuat.</span>
                    @endif
                </div>
            </div>

            {{-- Matches List Area --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                @if($tournament->rounds->count() > 0)
                    @foreach($tournament->rounds as $round)
                        <div x-show="selectedRound == '{{ $round->id }}'" style="display: none;">

                            {{-- Round Info Header (Clean White/Gray, No Gradient) --}}
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-bold text-purple-700 text-lg">{{ $round->name }}</h4>
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full {{ $round->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $round->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                                @if($round->motion)
                                    <div class="mt-2 text-sm text-black">
                                        <span class="font-semibold">Motion:</span> {{ $round->motion }}
                                    </div>
                                @endif
                            </div>

                            {{-- Matches Table --}}
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                                Venue / Room</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                                                Proposition (Gov)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                                                VS</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                                                Opposition (Opp)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                                                Adjudicators</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($round->matches as $match)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black">
                                                    {{ $match->room->name ?? 'TBA' }}
                                                </td>

                                                {{-- Team Gov --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="text-sm font-bold text-black">{{ $match->govTeam->emoji ?? '🛡️' }}
                                                        {{ $match->govTeam->name ?? 'N/A' }}</div>
                                                    <div class="text-xs text-black">{{ $match->govTeam->institution ?? '' }}</div>
                                                </td>

                                                {{-- VS Badge --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span
                                                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black bg-gray-200 rounded">
                                                        VS
                                                    </span>
                                                </td>

                                                {{-- Team Opp --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="text-sm font-bold text-black">{{ $match->oppTeam->emoji ?? '🔥' }}
                                                        {{ $match->oppTeam->name ?? 'N/A' }}</div>
                                                    <div class="text-xs text-black">{{ $match->oppTeam->institution ?? '' }}</div>
                                                </td>

                                                {{-- Adjudicators --}}
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex flex-col items-center gap-1">
                                                        @if($match->adjudicator)
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                                {{ $match->adjudicator->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-xs text-black italic">No Adjudicator</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-10 text-center text-black">
                                                    Belum ada pairing/match untuk ronde ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-10 text-center">
                        <svg class="mx-auto h-12 w-12 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-black">Tidak ada data</h3>
                        <p class="mt-1 text-sm text-black">Jadwal pertandingan belum tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection