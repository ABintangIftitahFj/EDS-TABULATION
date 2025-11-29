@extends('layouts.user')

@section('title', 'Participants - ' . $tournament->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                👥 PARTICIPANTS: {{ $tournament->name }}
            </h1>
        </div>

        {{-- Tabs Navigation --}}
        <div class="border-b-4 border-slate-200 mb-8 overflow-x-auto pb-1">
            <nav class="-mb-1 flex space-x-8 min-w-max" aria-label="Tabs">
                <a href="/tournaments" class="pixel-tab text-slate-600 hover:text-black">
                    ← ALL TOURNAMENTS
                </a>
                <a href="/tournaments/{{ $tournament->id }}" class="pixel-tab text-slate-600 hover:text-black">
                    🏠 OVERVIEW
                </a>
                <a href="/tournaments/{{ $tournament->id }}/motions" class="pixel-tab text-slate-600 hover:text-black">
                    💡 MOTIONS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/standings" class="pixel-tab text-slate-600 hover:text-black">
                    🏆 STANDINGS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/matches" class="pixel-tab text-slate-600 hover:text-black">
                    ⚔️ MATCHES & DRAW
                </a>
                <a href="/tournaments/{{ $tournament->id }}/results" class="pixel-tab text-slate-600 hover:text-black">
                    📊 RESULTS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/speakers" class="pixel-tab text-slate-600 hover:text-black">
                    🎤 SPEAKERS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/participants" class="pixel-tab pixel-tab-active">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Teams List --}}
            <div class="pixel-card overflow-hidden bg-white">
                <div class="px-6 py-4 border-b-4 border-slate-900 bg-england-blue flex justify-between items-center">
                    <h2 class="text-2xl font-pixel text-white">TEAMS</h2>
                    <span
                        class="px-3 py-1 bg-white text-england-blue text-sm font-pixel border-2 border-black shadow-pixel-sm">
                        {{ $tournament->teams->count() }} TEAMS
                    </span>
                </div>

                <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                    <table class="min-w-full divide-y-2 divide-slate-900">
                        <thead class="bg-slate-100 sticky top-0 z-10">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">
                                    Team Name</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider">Institution
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y-2 divide-slate-100">
                            @forelse($tournament->teams as $team)
                                <tr class="hover:bg-blue-50 transition-colors">
                                    <td class="px-6 py-4 border-r border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">{{ $team->emoji ?? '🛡️' }}</span>
                                            <span class="font-bold font-sans text-black">{{ $team->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-mono text-slate-600">{{ $team->institution }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-slate-500 font-pixel">
                                        No teams registered yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Adjudicators List --}}
            <div class="pixel-card overflow-hidden bg-white">
                <div class="px-6 py-4 border-b-4 border-slate-900 bg-england-red flex justify-between items-center">
                    <h2 class="text-2xl font-pixel text-white">ADJUDICATORS</h2>
                    <span
                        class="px-3 py-1 bg-white text-england-red text-sm font-pixel border-2 border-black shadow-pixel-sm">
                        {{ $tournament->adjudicators->count() }} ADJ
                    </span>
                </div>

                <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                    <table class="min-w-full divide-y-2 divide-slate-900">
                        <thead class="bg-slate-100 sticky top-0 z-10">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">
                                    Institution</th>
                                <th class="px-6 py-3 text-center text-lg font-pixel text-black tracking-wider">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y-2 divide-slate-100">
                            @forelse($tournament->adjudicators as $adj)
                                <tr class="hover:bg-red-50 transition-colors">
                                    <td class="px-6 py-4 border-r border-slate-100">
                                        <span class="font-bold font-sans text-black">{{ $adj->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 border-r border-slate-100">
                                        <span class="font-mono text-slate-600">{{ $adj->institution }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div
                                            class="inline-block px-2 py-1 bg-yellow-100 border border-yellow-300 rounded text-yellow-800 font-mono font-bold">
                                            {{ number_format($adj->rating, 1) }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-500 font-pixel">
                                        No adjudicators registered yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection