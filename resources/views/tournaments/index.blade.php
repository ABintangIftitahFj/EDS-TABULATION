@extends('layouts.user')

@section('content')

<div class="md:flex md:items-center md:justify-between mb-8">
    <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-black sm:truncate sm:text-3xl sm:tracking-tight">
            Tournaments
        </h2>
        <p class="mt-1 text-sm text-black">
            View ongoing and past debate tournaments.
        </p>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($tournaments ?? [] as $tournament)
        <div
            class="relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <span
                        class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $tournament->status === 'ongoing' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-slate-50 text-black ring-slate-500/10' }}">
                        {{ ucfirst($tournament->status) }}
                    </span>
                    <span class="text-xs text-black">{{ $tournament->format }}</span>
                </div>
                <h3 class="mt-4 text-lg font-semibold leading-6 text-black">
                    <a href="/tournaments/{{ $tournament->id }}">
                        <span class="absolute inset-0"></span>
                        {{ $tournament->name }}
                    </a>
                </h3>
                <p class="mt-2 text-sm text-black line-clamp-2">
                    {{ $tournament->description ?? 'No description available.' }}
                </p>
                <div class="mt-6 flex items-center gap-x-4 text-xs text-black">
                    <div class="flex items-center gap-x-1">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $tournament->start_date ? $tournament->start_date->format('M d, Y') : 'TBA' }}
                    </div>
                    <div class="flex items-center gap-x-1">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $tournament->location ?? 'Online' }}
                    </div>
                </div>
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
            <svg class="mx-auto h-12 w-12 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-black">No tournaments found</h3>
            <p class="mt-1 text-sm text-black">Check back later for upcoming events.</p>
        </div>
    @endforelse
</div>

@endsection
