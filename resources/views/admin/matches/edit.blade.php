@extends('layouts.admin')

@section('title', 'Edit Match')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black">Edit Match</h1>
        <p class="text-black">Update debate match pairing</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="{{ route('admin.matches.update', $match) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="round_id" class="block text-sm font-medium text-black">Round</label>
                    <select id="round_id" name="round_id" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Round</option>
                        @foreach ($rounds as $round)
                            <option value="{{ $round->id }}" {{ $match->round_id == $round->id ? 'selected' : '' }}>
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
                            <option value="{{ $room->id }}" {{ $match->room_id == $room->id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="og_team_id" class="block text-sm font-medium text-black">Opening Government
                            (OG)</label>
                        <select id="og_team_id" name="og_team_id" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{ $match->og_team_id == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->institution }})
                                </option>
                            @endforeach
                        </select>
                        @error('og_team_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="oo_team_id" class="block text-sm font-medium text-black">Opening Opposition
                            (OO)</label>
                        <select id="oo_team_id" name="oo_team_id" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{ $match->oo_team_id == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->institution }})
                                </option>
                            @endforeach
                        </select>
                        @error('oo_team_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cg_team_id" class="block text-sm font-medium text-black">Closing Government
                            (CG)</label>
                        <select id="cg_team_id" name="cg_team_id" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{ $match->cg_team_id == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->institution }})
                                </option>
                            @endforeach
                        </select>
                        @error('cg_team_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="co_team_id" class="block text-sm font-medium text-black">Closing Opposition
                            (CO)</label>
                        <select id="co_team_id" name="co_team_id" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{ $match->co_team_id == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->institution }})
                                </option>
                            @endforeach
                        </select>
                        @error('co_team_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="chair_id" class="block text-sm font-medium text-black">Chair Adjudicator</label>
                    <select id="chair_id" name="chair_id"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Chair (Optional)</option>
                        @foreach ($adjudicators as $adjudicator)
                            <option value="{{ $adjudicator->id }}" {{ $match->chair_id == $adjudicator->id ? 'selected' : '' }}>
                                {{ $adjudicator->name }} ({{ $adjudicator->institution }})
                            </option>
                        @endforeach
                    </select>
                    @error('chair_id')
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
                    Update Match
                </button>
            </div>
        </form>
    </div>
@endsection
