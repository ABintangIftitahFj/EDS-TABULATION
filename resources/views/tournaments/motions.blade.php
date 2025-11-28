@extends('layouts.user')

@section('content')

    <div class="flex items-center gap-2 mb-2">
        <a href="/tournaments/{{ $tournament->id }}" class="text-sm text-slate-500 hover:text-slate-700">
            &larr; Back to Dashboard
        </a>
    </div>
    <h1 class="text-3xl font-bold leading-tight bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
        💡 Motions: {{ $tournament->name }}
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
                class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                Matches &amp; Draw
            </a>
            <a href="/tournaments/{{ $tournament->id }}/motions"
                class="border-indigo-500 text-indigo-600 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium"
                aria-current="page">
                💡 Motions
            </a>
        </nav>
    </div>

    <!-- Motions Content -->
    <div class="mt-8 space-y-8">
        @forelse($tournament->rounds as $round)
            <div class="bg-white shadow-lg ring-1 ring-slate-200 rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-indigo-50 to-purple-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-900">📢 {{ $round->name }}</h3>
                    <span
                        class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-700/10">✅ Released</span>
                </div>
                <div class="p-8 text-center bg-gradient-to-b from-white to-slate-50">
                    <p class="text-sm text-slate-500 uppercase tracking-widest mb-4 flex items-center justify-center gap-2">
                        <span>✨</span> Motion <span>✨</span>
                    </p>
                    <blockquote class="text-2xl font-serif italic text-slate-900 max-w-4xl mx-auto leading-relaxed">
                        “{{ $round->motion }}”
                    </blockquote>
                    @if($round->info_slide)
                        <div class="mt-8 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg text-left max-w-3xl mx-auto border border-yellow-200 shadow-sm">
                            <p class="text-xs font-bold text-yellow-800 uppercase mb-1">📝 Info Slide</p>
                            <p class="text-sm text-yellow-900">{{ $round->info_slide }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2 2h-7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-slate-900">No motions released</h3>
                <p class="mt-1 text-sm text-slate-500">Motions will appear here once they are published by the adjudication
                    core.</p>
            </div>
        @endforelse
    </div>

@endsection