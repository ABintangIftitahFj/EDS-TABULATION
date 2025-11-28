@extends('layouts.user')

@section('content')

<div class="flex items-center gap-2 mb-2">
    <a href="/tournaments/{{ $tournament->id }}" class="text-sm text-slate-500 hover:text-slate-700">
        &larr; Back to Dashboard
    </a>
</div>
<h1 class="text-3xl font-bold leading-tight bg-gradient-to-r from-rose-600 to-orange-600 bg-clip-text text-transparent">
    ⚔️ Matches: {{ $tournament->name }}
</h1>

<!-- Tabs -->
<div class="mt-8 border-b border-slate-200">
    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
        <a href="/tournaments/{{ $tournament->id }}"
            class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Overview
        </a>
        <a href="/tournaments/{{ $tournament->id }}/standings"
            class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Standings
        </a>
        <a href="/tournaments/{{ $tournament->id }}/matches"
            class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium"
            aria-current="page">
            ⚔️ Matches &amp; Draw
        </a>
        <a href="/tournaments/{{ $tournament->id }}/motions"
            class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Motions
        </a>
    </nav>
</div>

<!-- Rounds and Matches -->
<div class="mt-8">
    @forelse($tournament->rounds as $round)
        <div class="mb-8">
            <h3 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">
                📢 {{ $round->name }}
            </h3>

            <!-- Motion Display -->
            @if($round->motions && $round->motions->count() > 0)
                @foreach($round->motions as $motion)
                    @if($motion->is_released)
                        <div class="mb-6">
                            @include('components.motion-card', ['motion' => $motion])
                        </div>
                    @endif
                @endforeach
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($round->matches as $match)
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-4 relative overflow-hidden">
                        <!-- Result Indicator -->
                        @if($match->result_status === 'confirmed')
                            <div
                                class="absolute top-0 right-0 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-[10px] px-2 py-1 rounded-bl-lg font-bold uppercase shadow-lg">
                                ✅ Completed
                            </div>
                        @endif

                        <div class="text-xs text-slate-500 mb-2 font-medium uppercase tracking-wide">
                            📍 {{ $match->room->name ?? 'TBA' }}
                        </div>

                        @if($tournament->format === 'british')
                            <!-- BP Format -->
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div
                                    class="bg-slate-50 p-2 rounded {{ $match->winner_id == $match->og_team_id ? 'ring-2 ring-green-500 bg-green-50' : '' }}">
                                    <span class="block text-xs text-slate-500">OG</span>
                                    <span class="font-medium">{{ $match->ogTeam->name ?? 'TBA' }}</span>
                                </div>
                                <div
                                    class="bg-slate-50 p-2 rounded {{ $match->winner_id == $match->oo_team_id ? 'ring-2 ring-green-500 bg-green-50' : '' }}">
                                    <span class="block text-xs text-slate-500">OO</span>
                                    <span class="font-medium">{{ $match->ooTeam->name ?? 'TBA' }}</span>
                                </div>
                                <div
                                    class="bg-slate-50 p-2 rounded {{ $match->winner_id == $match->cg_team_id ? 'ring-2 ring-green-500 bg-green-50' : '' }}">
                                    <span class="block text-xs text-slate-500">CG</span>
                                    <span class="font-medium">{{ $match->cgTeam->name ?? 'TBA' }}</span>
                                </div>
                                <div
                                    class="bg-slate-50 p-2 rounded {{ $match->winner_id == $match->co_team_id ? 'ring-2 ring-green-500 bg-green-50' : '' }}">
                                    <span class="block text-xs text-slate-500">CO</span>
                                    <span class="font-medium">{{ $match->coTeam->name ?? 'TBA' }}</span>
                                </div>
                            </div>
                        @else
                            <!-- AP Format -->
                            <div class="space-y-2">
                                <div
                                    class="flex justify-between items-center p-3 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg shadow-sm {{ $match->winner_id == $match->gov_team_id ? 'ring-2 ring-green-500' : '' }}">
                                    <span
                                        class="text-sm font-bold text-slate-900">🛡️ {{ $match->govTeam->name ?? 'Affirmative' }}</span>
                                    <span class="text-xs font-bold px-2 py-1 bg-indigo-600 text-white rounded">GOV</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-3 bg-gradient-to-r from-rose-50 to-pink-50 rounded-lg shadow-sm {{ $match->winner_id == $match->opp_team_id ? 'ring-2 ring-green-500' : '' }}">
                                    <span
                                        class="text-sm font-bold text-slate-900">🔥 {{ $match->oppTeam->name ?? 'Opposition' }}</span>
                                    <span class="text-xs font-bold px-2 py-1 bg-rose-600 text-white rounded">OPP</span>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <p class="text-xs text-slate-500">
                                <span class="font-medium text-slate-700">⚖️ Adjudicator:</span>
                                {{ $match->adjudicator->name ?? 'TBA' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
            <p class="text-sm text-slate-500">No rounds or matches published yet.</p>
        </div>
    @endforelse
</div>

@endsection