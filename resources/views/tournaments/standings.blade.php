@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold leading-tight text-purple-700">
                🏆 Standings: {{ $tournament->name }}
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
                    class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium"
                    aria-current="page">
                    🏆 Standings
                </a>
                <a href="/tournaments/{{ $tournament->id }}/matches"
                    class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
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

        <!-- Standings Content -->
        <div class="mt-8" x-data="{ tab: 'teams' }">
            <!-- Sub-tabs for Team/Speaker -->
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <select id="tabs" name="tabs"
                    class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    x-model="tab">
                    <option value="teams">Team Standings</option>
                    <option value="speakers">Speaker Standings</option>
                </select>
            </div>
            <div class="hidden sm:block mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="tab = 'teams'"
                            :class="tab === 'teams' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-black hover:border-gray-300 hover:text-black'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                            👥 Team Standings
                        </button>
                        <button @click="tab = 'speakers'"
                            :class="tab === 'speakers' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-black hover:border-gray-300 hover:text-black'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                            🎤 Speaker Standings
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Team Standings -->
            <div x-show="tab === 'teams'" class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Rank
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Team
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Institution</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">VP
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Speaker Score</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($tournament->teams as $index => $team)
                                <tr
                                    class="{{ $index < 3 ? 'bg-gradient-to-r from-yellow-50 to-orange-50' : 'hover:bg-slate-50' }} transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($index === 0)
                                            <span class="text-2xl" title="1st Place">🥇</span>
                                        @elseif($index === 1)
                                            <span class="text-2xl" title="2nd Place">🥈</span>
                                        @elseif($index === 2)
                                            <span class="text-2xl" title="3rd Place">🥉</span>
                                        @else
                                            <span class="text-black font-medium">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-black">{{ $team->emoji ?? '👥' }}
                                                {{ $team->name }}</span>
                                            @if($index < 4)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">Break</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">🏦 {{ $team->institution }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-indigo-100 text-indigo-700">
                                            ⚡ {{ $team->total_vp }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-black">📊
                                        {{ $team->total_speaker_score }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-black">
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
                class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Rank
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Speaker</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Team
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Total Score</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Average</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($speakers as $index => $speaker)
                                <tr
                                    class="{{ $loop->iteration <= 3 ? 'bg-gradient-to-r from-purple-50 to-pink-50' : 'hover:bg-slate-50' }} transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($loop->iteration === 1)
                                            <span class="text-2xl" title="Best Speaker">🏆</span>
                                        @elseif($loop->iteration === 2)
                                            <span class="text-2xl">🥈</span>
                                        @elseif($loop->iteration === 3)
                                            <span class="text-2xl">🥉</span>
                                        @else
                                            <span class="text-black font-medium">{{ $loop->iteration }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-black">🎤 {{ $speaker->name }}</span>
                                            @if($loop->iteration === 1)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">⭐
                                                    Top</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        {{ $speaker->team->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-purple-100 text-purple-700">
                                            🎯 {{ $speaker->total_score }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-black">
                                        {{ $tournament->rounds_count > 0 ? number_format($speaker->total_score / max(1, $tournament->rounds_count), 2) : '0.00' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-black">
                                        No speakers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection