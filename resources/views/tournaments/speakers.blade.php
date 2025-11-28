@extends('layouts.user')

@section('title', 'Speakers - ' . $tournament->name)
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
                class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                ⚔️ Matches & Draw
            </a>
            <a href="/tournaments/{{ $tournament->id }}/results"
                class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                📊 Results
            </a>
            <a href="/tournaments/{{ $tournament->id }}/speakers"
                class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium"
                aria-current="page">
                🎤 Speakers
            </a>
            <a href="/tournaments/{{ $tournament->id }}/motions"
                class="border-transparent text-black hover:border-slate-300 hover:text-black whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                💡 Motions
            </a>
        </nav>
    </div>

    {{-- Speaker Rankings Table --}}
    <div class="bg-white rounded-xl shadow-lg ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-black">Individual Speaker Rankings</h2>
                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full">
                    {{ $speakers->count() }} Speakers
                </span>
            </div>
        </div>

        @if($speakers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Speaker</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Team & Institution</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">Total Points</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">Speeches</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">Avg Score</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">Highest Score</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($speakers as $speaker)
                            <tr class="hover:bg-slate-50 transition-colors {{ $speaker->rank <= 3 ? 'bg-gradient-to-r from-yellow-50 to-orange-50' : '' }}">
                                {{-- Rank --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($speaker->rank == 1)
                                            <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">🥇</span>
                                            </div>
                                        @elseif($speaker->rank == 2)
                                            <div class="w-8 h-8 bg-gradient-to-br from-gray-300 to-gray-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">🥈</span>
                                            </div>
                                        @elseif($speaker->rank == 3)
                                            <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-amber-700 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">🥉</span>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 bg-gradient-to-br from-slate-400 to-slate-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">{{ $speaker->rank }}</span>
                                            </div>
                                        @endif
                                        <span class="ml-3 text-sm font-medium text-black">#{{ $speaker->rank }}</span>
                                    </div>
                                </td>

                                {{-- Speaker Name --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-bold text-black">{{ $speaker->name }}</div>
                                            @if($speaker->rank <= 3)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    {{ $speaker->rank == 1 ? 'Best Speaker' : ($speaker->rank == 2 ? '2nd Best' : '3rd Best') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Team & Institution --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-black">{{ $speaker->team->emoji ?? '👥' }} {{ $speaker->team->name ?? 'Unknown Team' }}</div>
                                    <div class="text-xs text-black">{{ $speaker->team->institution ?? 'Unknown Institution' }}</div>
                                </td>

                                {{-- Total Points --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-lg font-bold text-indigo-600">{{ $speaker->total_score ?? 0 }}</div>
                                </td>

                                {{-- Speeches --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-medium text-black">{{ $speaker->ballots_count ?? 0 }}</div>
                                </td>

                                {{-- Average Score --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-medium text-black">
                                        {{ $speaker->ballots_count > 0 ? number_format(($speaker->total_score ?? 0) / $speaker->ballots_count, 1) : '0.0' }}
                                    </div>
                                </td>

                                {{-- Highest Score --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-medium text-black">
                                        @php
                                            $scores = [];
                                            if ($speaker->ballots ?? false) {
                                                $scores = $speaker->ballots->pluck('score')->toArray();
                                            }
                                            $highest = $scores ? max($scores) : 0;
                                        @endphp
                                        {{ $highest }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-black mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="text-lg font-medium text-black mb-2">No Speakers Found</h3>
                <p class="text-sm text-black">Speaker rankings will appear here once matches are completed</p>
            </div>
        @endif
    </div>

    {{-- Summary Stats --}}
    @if($speakers->count() > 0)
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">🏆</span>
                    <div>
                        <p class="text-sm font-medium text-black">Best Speaker</p>
                        <p class="text-xl font-bold text-black">{{ $speakers->first()->name ?? 'N/A' }}</p>
                        <p class="text-sm text-black">{{ $speakers->first()->total_score ?? 0 }} points</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">📊</span>
                    <div>
                        <p class="text-sm font-medium text-black">Average Score</p>
                        <p class="text-xl font-bold text-black">{{ $speakers->count() > 0 ? number_format($speakers->avg('total_score'), 1) : '0.0' }}</p>
                        <p class="text-sm text-black">across all speakers</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">🎯</span>
                    <div>
                        <p class="text-sm font-medium text-black">Highest Score</p>
                        <p class="text-xl font-bold text-black">{{ $speakers->max('total_score') ?? 0 }}</p>
                        <p class="text-sm text-black">single speech score</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection