@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Tournament Header --}}
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                💡 MOTIONS: {{ $tournament->name }}
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
                <a href="/tournaments/{{ $tournament->id }}/motions" class="pixel-tab pixel-tab-active">
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
                <a href="/tournaments/{{ $tournament->id }}/participants" class="pixel-tab text-slate-600 hover:text-black">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        <!-- Motions Content -->
        <div class="mt-8 space-y-8">
            @forelse($tournament->rounds as $round)
                <div class="pixel-card overflow-hidden bg-white hover:shadow-pixel-lg transition-all duration-300">
                    <div class="px-6 py-4 border-b-4 border-slate-900 bg-england-blue flex justify-between items-center">
                        <h3 class="text-2xl font-pixel text-white">{{ $round->name }}</h3>
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-pixel bg-green-400 text-black border-2 border-black shadow-pixel-sm transform rotate-2">
                            ✅ RELEASED
                        </span>
                    </div>
                    <div class="p-10 text-center bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                        <p
                            class="text-sm font-pixel text-england-red uppercase tracking-widest mb-6 flex items-center justify-center gap-2">
                            <span>✨</span> OFFICIAL MOTION <span>✨</span>
                        </p>
                        <blockquote
                            class="text-3xl font-serif italic text-black max-w-4xl mx-auto leading-relaxed drop-shadow-sm">
                            “{{ $round->motion }}”
                        </blockquote>
                        @if($round->info_slide)
                            <div
                                class="mt-10 p-6 bg-yellow-50 border-2 border-black shadow-pixel-sm text-left max-w-3xl mx-auto relative">
                                <span
                                    class="absolute -top-3 -left-3 bg-yellow-400 border-2 border-black px-2 py-1 text-xs font-pixel text-black shadow-sm transform -rotate-6">INFO
                                    SLIDE</span>
                                <p class="text-base font-sans text-black leading-relaxed">{{ $round->info_slide }}</p>
                            </div>
                        @endif
                        
                        <!-- See Draw Button -->
                        <div class="mt-8">
                            <a href="/tournaments/{{ $tournament->id }}/matches?round={{ $round->id }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 font-pixel text-white bg-england-blue border-2 border-black shadow-pixel hover:shadow-pixel-lg hover:-translate-y-1 transition-all duration-200 transform hover:rotate-1">
                                <span>⚔️</span> SEE DRAW
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="pixel-card p-12 text-center bg-white border-dashed">
                    <div class="inline-block p-6 bg-slate-100 rounded-full border-4 border-slate-200 mb-6">
                        <svg class="h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2 2h-7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-pixel text-black mb-2">NO MOTIONS YET</h3>
                    <p class="text-base font-sans text-slate-500">Motions will appear here once published.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection