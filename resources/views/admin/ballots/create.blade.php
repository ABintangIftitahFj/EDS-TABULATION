@extends('layouts.admin')

@section('title', 'Enter Ballot')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Enter Ballot: {{ $match->round->name }}
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $match->round->tournament->name }} • {{ $match->room->name ?? 'Room TBA' }}
                </p>
            </div>
        </div>

        <form action="{{ route('admin.ballots.store', $match->id) }}" method="POST" class="space-y-8">
            @csrf

            @if($match->round->tournament->format === 'british')
                <!-- BP Format Form -->
                <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Opening Government</h3>
                    @foreach($match->ogTeam->speakers as $speaker)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700">{{ $speaker->name }}</label>
                            <input type="number" name="scores[{{ $speaker->id }}]" min="50" max="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                        </div>
                    @endforeach
                </div>
                <!-- Repeat for OO, CG, CO... (Simplified for brevity) -->
            @else
                <!-- AP Format Form -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Government -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-indigo-600 mb-4 border-b pb-2">Government:
                            {{ $match->govTeam->name }}</h3>
                        <div class="space-y-4">
                            @foreach($match->govTeam->speakers as $speaker)
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">{{ $speaker->name }}</label>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="scores[{{ $speaker->id }}]" min="68" max="82" step="0.5"
                                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Score (68-82)" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Opposition -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-rose-600 mb-4 border-b pb-2">Opposition:
                            {{ $match->oppTeam->name }}</h3>
                        <div class="space-y-4">
                            @foreach($match->oppTeam->speakers as $speaker)
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">{{ $speaker->name }}</label>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="scores[{{ $speaker->id }}]" min="68" max="82" step="0.5"
                                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Score (68-82)" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex items-center justify-end gap-x-6">
                <a href="{{ route('admin.ballots.index') }}"
                    class="text-sm font-semibold leading-6 text-slate-900">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit
                    Ballot</button>
            </div>
        </form>
    </div>
@endsection