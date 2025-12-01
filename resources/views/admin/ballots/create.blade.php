@extends('layouts.admin')

@section('title', 'Enter Ballot')

@section('content')
    {{-- Fix Overlap: Menambahkan padding dan container yang responsif --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Enter Ballot: {{ $match->round->title ?? 'Round' }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $match->round->tournament->name ?? 'Tournament' }} • {{ $match->room->name ?? 'Room TBA' }}
                </p>
            </div>
        </div>

        {{-- Alert Range Info --}}
        <div class="rounded-md bg-blue-50 p-4 mb-6 border-l-4 border-blue-400">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Scoring Guidelines</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul role="list" class="list-disc space-y-1 pl-5">
                            <li>Speaker Score Range: <strong>69 - 85</strong> (Default: 75)</li>
                            <li>Reply Score Range: <strong>32 - 42</strong> (Default: 36)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.ballots.store', $match->id) }}" method="POST" class="space-y-8">
            @csrf

            @if($match->round->tournament->format === 'british')
                {{-- BP Format (Tetap sama, ranking 1-4) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- ... (Kode BP tetap sama seperti sebelumnya jika tidak ada perubahan rule) ... --}}
                    {{-- Gunakan kode BP dari file sebelumnya di sini --}}
                </div>
            @else
                {{-- Asian Parliamentary Format (Updated Defaults) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Government Team --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-indigo-600 mb-4 border-b pb-2 flex justify-between">
                            <span>Government</span>
                            <span class="text-sm text-gray-500 font-normal">{{ $match->teamGov->name }}</span>
                        </h3>
                        <div class="space-y-5">
                            @foreach($match->teamGov->speakers as $speaker)
                                <div>
                                    <label class="block text-sm font-medium text-gray-900">{{ $speaker->name }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" name="scores[{{ $speaker->id }}]" value="75" min="69" max="85" step="1"
                                            class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            required>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-400 sm:text-xs">/ 100</span>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Range: 69-85</p>
                                </div>
                            @endforeach
                        </div>

                        {{-- Gov Reply --}}
                        <div class="mt-6 pt-4 border-t border-gray-100 bg-gray-50 -mx-6 px-6 pb-2">
                            <div class="flex items-center mb-2 mt-2">
                                <input type="checkbox" id="gov_reply_check" onchange="toggleReply('gov')"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="gov_reply_check" class="ml-2 block text-sm font-bold text-gray-700">Gov Reply
                                    Speech</label>
                            </div>
                            <div id="gov_reply_input" class="hidden pl-6 border-l-2 border-indigo-200">
                                <label class="block text-sm font-medium text-gray-700">Score</label>
                                <input type="number" name="reply_scores[{{ $match->teamGov->id }}]" value="36" min="32" max="42"
                                    step="0.5"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">Range: 32-42</p>
                            </div>
                        </div>
                    </div>

                    {{-- Opposition Team --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-rose-600 mb-4 border-b pb-2 flex justify-between">
                            <span>Opposition</span>
                            <span class="text-sm text-gray-500 font-normal">{{ $match->teamOpp->name }}</span>
                        </h3>
                        <div class="space-y-5">
                            @foreach($match->teamOpp->speakers as $speaker)
                                <div>
                                    <label class="block text-sm font-medium text-gray-900">{{ $speaker->name }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" name="scores[{{ $speaker->id }}]" value="75" min="69" max="85" step="1"
                                            class="block w-full rounded-md border-gray-300 focus:border-rose-500 focus:ring-rose-500 sm:text-sm"
                                            required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Range: 69-85</p>
                                </div>
                            @endforeach
                        </div>

                        {{-- Opp Reply --}}
                        <div class="mt-6 pt-4 border-t border-gray-100 bg-gray-50 -mx-6 px-6 pb-2">
                            <div class="flex items-center mb-2 mt-2">
                                <input type="checkbox" id="opp_reply_check" onchange="toggleReply('opp')"
                                    class="h-4 w-4 rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                                <label for="opp_reply_check" class="ml-2 block text-sm font-bold text-gray-700">Opp Reply
                                    Speech</label>
                            </div>
                            <div id="opp_reply_input" class="hidden pl-6 border-l-2 border-rose-200">
                                <label class="block text-sm font-medium text-gray-700">Score</label>
                                <input type="number" name="reply_scores[{{ $match->teamOpp->id }}]" value="36" min="32" max="42"
                                    step="0.5"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">Range: 32-42</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Verdict Selection --}}
                <div class="mt-8 bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Verdict Override (Optional)</h3>
                    <p class="text-sm text-gray-500 mb-4">If left unselected, winner is calculated by total score.</p>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="winner_id" value="{{ $match->teamGov->id }}"
                                class="h-5 w-5 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-900 font-medium">Government Win</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="winner_id" value="{{ $match->teamOpp->id }}"
                                class="h-5 w-5 text-rose-600 focus:ring-rose-500">
                            <span class="text-gray-900 font-medium">Opposition Win</span>
                        </label>
                    </div>
                </div>
            @endif

            <div class="mt-6 flex items-center justify-end gap-x-6 pb-10">
                <a href="{{ route('admin.matches.index') }}"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Submit Ballot
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleReply(side) {
            const checkbox = document.getElementById(`${side}_reply_check`);
            const inputDiv = document.getElementById(`${side}_reply_input`);

            if (checkbox.checked) {
                inputDiv.classList.remove('hidden');
            } else {
                inputDiv.classList.add('hidden');
            }
        }
    </script>
@endsection