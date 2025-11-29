@extends('layouts.admin')

@section('title', 'Enter Ballot')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-black sm:truncate sm:text-3xl sm:tracking-tight">
                    Enter Ballot: {{ $match->round->name }}
                </h2>
                <p class="mt-1 text-sm text-black">
                    {{ $match->round->tournament->name }} • {{ $match->room->name ?? 'Room TBA' }}
                </p>
            </div>
        </div>

        <form action="{{ route('admin.ballots.store', $match->id) }}" method="POST" class="space-y-8">
            @csrf

            @if($match->round->tournament->format === 'british')
                <!-- BP Format Form: Rank Teams 1-4 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- OG -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Opening Government (OG)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->govTeam->name }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->govTeam->id }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>

                    <!-- OO -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Opening Opposition (OO)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->oppTeam->name }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->oppTeam->id }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>

                    <!-- CG -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Closing Government (CG)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->cgTeam->name ?? 'N/A' }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->cgTeam->id ?? '' }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            {{ $match->cgTeam ? 'required' : 'disabled' }}>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>

                    <!-- CO -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Closing Opposition (CO)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->coTeam->name ?? 'N/A' }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->coTeam->id ?? '' }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            {{ $match->coTeam ? 'required' : 'disabled' }}>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>
                </div>
            @else
                <!-- AP Format Form -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
@extends('layouts.admin')

@section('title', 'Enter Ballot')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-black sm:truncate sm:text-3xl sm:tracking-tight">
                    Enter Ballot: {{ $match->round->name }}
                </h2>
                <p class="mt-1 text-sm text-black">
                    {{ $match->round->tournament->name }} • {{ $match->room->name ?? 'Room TBA' }}
                </p>
            </div>
        </div>

        <form action="{{ route('admin.ballots.store', $match->id) }}" method="POST" class="space-y-8">
            @csrf

            @if($match->round->tournament->format === 'british')
                <!-- BP Format Form: Rank Teams 1-4 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- OG -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Opening Government (OG)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->govTeam->name }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->govTeam->id }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>

                    <!-- OO -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Opening Opposition (OO)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->oppTeam->name }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->oppTeam->id }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>

                    <!-- CG -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Closing Government (CG)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->cgTeam->name ?? 'N/A' }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->cgTeam->id ?? '' }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            {{ $match->cgTeam ? 'required' : 'disabled' }}>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>

                    <!-- CO -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Closing Opposition (CO)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->coTeam->name ?? 'N/A' }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->coTeam->id ?? '' }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            {{ $match->coTeam ? 'required' : 'disabled' }}>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>
                </div>
            @else
                <!-- AP Format Form -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Government -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-indigo-600 mb-4 border-b pb-2">Government:
                            {{ $match->govTeam->name }}
                        </h3>
                        <div class="space-y-4">
                            @foreach($match->govTeam->speakers as $speaker)
                                <div>
                                    <label class="block text-sm font-medium text-black">{{ $speaker->name }}</label>
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
                            {{ $match->oppTeam->name }}
                        </h3>
                        <div class="space-y-4">
                            @foreach($match->oppTeam->speakers as $speaker)
                                <div>
                                    <label class="block text-sm font-medium text-black">{{ $speaker->name }}</label>
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

                <!-- Verdict Selection -->
                <div class="mt-8 bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Verdict</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                            <input type="radio" name="winner_id" value="{{ $match->govTeam->id }}" class="sr-only" aria-labelledby="project-type-0-label" aria-describedby="project-type-0-description-0 project-type-0-description-1">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span id="project-type-0-label" class="block text-sm font-medium text-gray-900">Government Win</span>
                                    <span id="project-type-0-description-0" class="mt-1 flex items-center text-sm text-gray-500">{{ $match->govTeam->name }}</span>
                                </span>
                            </span>
                            <svg class="h-5 w-5 text-indigo-600 hidden checked-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="pointer-events-none absolute -inset-px rounded-lg border-2 border-transparent peer-checked:border-indigo-600" aria-hidden="true"></span>
                        </label>

                        <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                            <input type="radio" name="winner_id" value="{{ $match->oppTeam->id }}" class="sr-only" aria-labelledby="project-type-1-label" aria-describedby="project-type-1-description-0 project-type-1-description-1">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span id="project-type-1-label" class="block text-sm font-medium text-gray-900">Opposition Win</span>
                                    <span id="project-type-1-description-0" class="mt-1 flex items-center text-sm text-gray-500">{{ $match->oppTeam->name }}</span>
                                </span>
                            </span>
                            <svg class="h-5 w-5 text-indigo-600 hidden checked-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="pointer-events-none absolute -inset-px rounded-lg border-2 border-transparent peer-checked:border-indigo-600" aria-hidden="true"></span>
                        </label>
                    </div>
                </div>

                <style>
                    input[type="radio"]:checked ~ .checked-icon {
                        display: block;
                    }
                    input[type="radio"]:checked ~ .pointer-events-none {
                        border-color: #4f46e5;
                    }
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>

                    <!-- CO -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Closing Opposition (CO)</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $match->coTeam->name ?? 'N/A' }}</p>
                        <label class="block text-sm font-medium text-black">Rank (1-4)</label>
                        <select name="ranks[{{ $match->coTeam->id ?? '' }}]"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            {{ $match->coTeam ? 'required' : 'disabled' }}>
                            <option value="">Select Rank</option>
                            <option value="1">1st (3 points)</option>
                            <option value="2">2nd (2 points)</option>
                            <option value="3">3rd (1 point)</option>
                            <option value="4">4th (0 points)</option>
                        </select>
                    </div>
                </div>
            @else
                <!-- AP Format Form -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Government -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-indigo-600 mb-4 border-b pb-2">Government:
                            {{ $match->govTeam->name }}
                        </h3>
                        <div class="space-y-4">
                            @foreach($match->govTeam->speakers as $speaker)
                                <div>
                                    <label class="block text-sm font-medium text-black">{{ $speaker->name }}</label>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="scores[{{ $speaker->id }}]" min="68" max="82" step="0.5"
                                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Score (68-82)" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="gov_reply_check" onchange="toggleReply('gov')"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="gov_reply_check" class="ml-2 block text-sm font-medium text-black">Reply Score</label>
                            </div>
                            <div id="gov_reply_input" class="hidden">
                                <label class="block text-sm font-medium text-black">Reply Speaker Score</label>
                                <input type="number" name="reply_scores[{{ $match->govTeam->id }}]" min="34" max="41" step="0.5"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Reply Score (34-41)">
                            </div>
                        </div>
                    </div>

                    <!-- Opposition -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-rose-600 mb-4 border-b pb-2">Opposition:
                            {{ $match->oppTeam->name }}
                        </h3>
                        <div class="space-y-4">
                            @foreach($match->oppTeam->speakers as $speaker)
                                <div>
                                    <label class="block text-sm font-medium text-black">{{ $speaker->name }}</label>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="scores[{{ $speaker->id }}]" min="68" max="82" step="0.5"
                                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Score (68-82)" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="opp_reply_check" onchange="toggleReply('opp')"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="opp_reply_check" class="ml-2 block text-sm font-medium text-black">Reply Score</label>
                            </div>
                            <div id="opp_reply_input" class="hidden">
                                <label class="block text-sm font-medium text-black">Reply Speaker Score</label>
                                <input type="number" name="reply_scores[{{ $match->oppTeam->id }}]" min="34" max="41" step="0.5"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Reply Score (34-41)">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verdict Selection -->
                <div class="mt-8 bg-white shadow-sm ring-1 ring-slate-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Verdict</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                            <input type="radio" name="winner_id" value="{{ $match->govTeam->id }}" class="sr-only" aria-labelledby="project-type-0-label" aria-describedby="project-type-0-description-0 project-type-0-description-1">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span id="project-type-0-label" class="block text-sm font-medium text-gray-900">Government Win</span>
                                    <span id="project-type-0-description-0" class="mt-1 flex items-center text-sm text-gray-500">{{ $match->govTeam->name }}</span>
                                </span>
                            </span>
                            <svg class="h-5 w-5 text-indigo-600 hidden checked-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="pointer-events-none absolute -inset-px rounded-lg border-2 border-transparent peer-checked:border-indigo-600" aria-hidden="true"></span>
                        </label>

                        <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                            <input type="radio" name="winner_id" value="{{ $match->oppTeam->id }}" class="sr-only" aria-labelledby="project-type-1-label" aria-describedby="project-type-1-description-0 project-type-1-description-1">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span id="project-type-1-label" class="block text-sm font-medium text-gray-900">Opposition Win</span>
                                    <span id="project-type-1-description-0" class="mt-1 flex items-center text-sm text-gray-500">{{ $match->oppTeam->name }}</span>
                                </span>
                            </span>
                            <svg class="h-5 w-5 text-indigo-600 hidden checked-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="pointer-events-none absolute -inset-px rounded-lg border-2 border-transparent peer-checked:border-indigo-600" aria-hidden="true"></span>
                        </label>
                    </div>
                </div>

                <style>
                    input[type="radio"]:checked ~ .checked-icon {
                        display: block;
                    }
                    input[type="radio"]:checked ~ .pointer-events-none {
                        border-color: #4f46e5;
                    }
                </style>
            @endif

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('admin.matches.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Complete Ballot
                </button>
            </div>
        </form>
    </div>
    </div>

    <script>
        function toggleReply(side) {
            const checkbox = document.getElementById(`${side}_reply_check`);
            const inputDiv = document.getElementById(`${side}_reply_input`);
            const input = inputDiv.querySelector('input');

            if (checkbox.checked) {
                inputDiv.classList.remove('hidden');
                input.required = true;
            } else {
                inputDiv.classList.add('hidden');
                input.required = false;
                input.value = '';
            }
        }
    </script>
@endsection