@extends('layouts.admin')

@section('title', 'Create Match')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black">Create New Match</h1>
        <p class="text-black">Set up a debate match pairing</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="{{ route('admin.matches.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="round_id" class="block text-sm font-medium text-black">Round</label>
                    <select id="round_id" name="round_id" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        onchange="updateFormFormat()">
                        <option value="">Select Round</option>
                        @foreach ($rounds as $round)
                            <option value="{{ $round->id }}" data-format="{{ $round->tournament->format }}" {{ (old('round_id') ?? request('round_id')) == $round->id ? 'selected' : '' }}>
                                {{ $round->tournament->name ?? 'N/A' }} - {{ $round->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('round_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="room_id" class="block text-sm font-medium text-black">Room</label>
                    <select id="room_id" name="room_id"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Room (Optional)</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="gov_team_id" id="gov_label"
                            class="block text-sm font-medium text-black">Government</label>
                        <select id="gov_team_id" name="gov_team_id" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->institution }})</option>
                            @endforeach
                        </select>
                        @error('gov_team_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="opp_team_id" id="opp_label"
                            class="block text-sm font-medium text-black">Opposition</label>
                        <select id="opp_team_id" name="opp_team_id" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->institution }})</option>
                            @endforeach
                        </select>
                        @error('opp_team_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="bp_fields" class="contents hidden">
                        <div>
                            <label for="cg_team_id" class="block text-sm font-medium text-black">Closing Government
                                (CG)</label>
                            <select id="cg_team_id" name="cg_team_id"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Team</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->institution }})</option>
                                @endforeach
                            </select>
                            @error('cg_team_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="co_team_id" class="block text-sm font-medium text-black">Closing Opposition
                                (CO)</label>
                            <select id="co_team_id" name="co_team_id"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Team</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->institution }})</option>
                                @endforeach
                            </select>
                            @error('co_team_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="adjudicator_id" class="block text-sm font-medium text-black">Adjudicator</label>
                    <select id="adjudicator_id" name="adjudicator_id"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Adjudicator (Optional)</option>
                        @foreach ($adjudicators as $adjudicator)
                            <option value="{{ $adjudicator->id }}">{{ $adjudicator->name }}
                                ({{ $adjudicator->institution }})</option>
                        @endforeach
                    </select>
                    @error('adjudicator_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="{{ route('admin.matches.index') }}"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-black shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
                    Create Match
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function updateFormFormat() {
                const select = document.getElementById('round_id');
                const option = select.options[select.selectedIndex];
                const format = option.dataset.format;
                const bpFields = document.getElementById('bp_fields');
                const govLabel = document.getElementById('gov_label');
                const oppLabel = document.getElementById('opp_label');

                if (format === 'british') {
                    bpFields.classList.remove('hidden');
                    govLabel.textContent = 'Opening Government (OG)';
                    oppLabel.textContent = 'Opening Opposition (OO)';
                } else {
                    bpFields.classList.add('hidden');
                    govLabel.textContent = 'Government';
                    oppLabel.textContent = 'Opposition';
                    // Clear BP fields
                    document.getElementById('cg_team_id').value = '';
                    document.getElementById('co_team_id').value = '';
                }
            }
        </script>
    @endpush
@endsection