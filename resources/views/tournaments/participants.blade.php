@extends('layouts.user')

@section('title', 'Speakers List - ' . $tournament->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                🎤 SPEAKER LIST: {{ $tournament->name }}
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
                <a href="/tournaments/{{ $tournament->id }}/adjudicators" class="pixel-tab text-slate-600 hover:text-black">
                    ⚖️ ADJUDICATORS
                </a>
                <a href="/tournaments/{{ $tournament->id }}/participants" class="pixel-tab pixel-tab-active">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        {{-- Speakers List --}}
        <div class="pixel-card overflow-hidden bg-white">
            <div class="px-6 py-4 border-b-4 border-slate-900 bg-england-red flex justify-between items-center">
                <h2 class="text-2xl font-pixel text-white">SPEAKER LIST</h2>
                @php
                    $allSpeakers = $tournament->teams->flatMap->speakers;
                @endphp
                <span class="px-3 py-1 bg-white text-england-red text-sm font-pixel border-2 border-black shadow-pixel-sm">
                    {{ $allSpeakers->count() }} SPEAKERS
                </span>
            </div>

            @if($allSpeakers->count() > 0)
                {{-- Desktop Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-slate-900">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">#</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Name</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider">Institution</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y-2 divide-slate-100">
                            @foreach($allSpeakers->sortBy('name') as $index => $speaker)
                                <tr class="hover:bg-red-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="w-8 h-8 bg-england-red/10 border-2 border-england-red/30 flex items-center justify-center rounded">
                                            <span class="text-england-red font-pixel text-sm">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-england-red border-2 border-black shadow-pixel-sm flex items-center justify-center">
                                                <span class="text-white font-pixel text-lg">{{ strtoupper(substr($speaker->name, 0, 1)) }}</span>
                                            </div>
                                            <span class="text-lg font-bold font-sans text-black">{{ $speaker->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-600 font-sans">{{ $speaker->team->institution ?? '-' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="md:hidden divide-y divide-slate-200">
                    @foreach($allSpeakers->sortBy('name') as $index => $speaker)
                        <div class="p-4 hover:bg-red-50/50 flex items-center gap-3">
                            <div class="w-8 h-8 bg-england-red/10 border-2 border-england-red/30 flex items-center justify-center rounded flex-shrink-0">
                                <span class="text-england-red font-pixel text-sm">{{ $index + 1 }}</span>
                            </div>
                            <div class="w-10 h-10 bg-england-red border-2 border-black shadow-pixel-sm flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-pixel text-lg">{{ strtoupper(substr($speaker->name, 0, 1)) }}</span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base font-bold font-sans text-black truncate">{{ $speaker->name }}</h3>
                                <p class="text-sm text-slate-600">{{ $speaker->team->institution ?? '-' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 border-2 border-slate-300 flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">🎤</span>
                    </div>
                    <p class="text-xl font-pixel text-slate-500">No speakers yet</p>
                    <p class="text-slate-400 mt-2">Speakers will appear here once teams are added.</p>
                </div>
            @endif
        </div>
    </div>
@endsection