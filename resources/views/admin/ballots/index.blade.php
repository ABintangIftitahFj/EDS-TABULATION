@extends('layouts.admin')

@section('title', 'Ballot Entry')

@section('content')
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-slate-900">Ballot Entry</h1>
            <p class="mt-2 text-sm text-slate-700">Select a match to enter scores.</p>
        </div>
    </div>

    <!-- Tournament Selector -->
    <div class="mt-6">
        <form action="{{ route('admin.ballots.index') }}" method="GET" class="flex gap-4 items-end">
            <div>
                <label for="tournament_id" class="block text-sm font-medium leading-6 text-slate-900">Tournament</label>
                <select id="tournament_id" name="tournament_id" onchange="this.form.submit()"
                    class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    @foreach($tournaments as $tournament)
                        <option value="{{ $tournament->id }}" {{ $selectedTournament && $selectedTournament->id == $tournament->id ? 'selected' : '' }}>
                            {{ $tournament->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-slate-300">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Round
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Room</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Matchup
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">
                                    Adjudicators</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Status
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Enter</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($matches as $match)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">
                                        {{ $match->round->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                        {{ $match->room->name ?? 'TBA' }}</td>
                                    <td class="px-3 py-4 text-sm text-slate-500">
                                        @if($selectedTournament->format === 'british')
                                            OG: {{ $match->ogTeam->name }}<br>
                                            OO: {{ $match->ooTeam->name }}<br>
                                            CG: {{ $match->cgTeam->name }}<br>
                                            CO: {{ $match->coTeam->name }}
                                        @else
                                            Gov: {{ $match->govTeam->name }}<br>
                                            Opp: {{ $match->oppTeam->name }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 text-sm text-slate-500">
                                        {{ $match->adjudicators->pluck('name')->join(', ') }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                        <span
                                            class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $match->result_status === 'confirmed' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-yellow-50 text-yellow-800 ring-yellow-600/20' }}">
                                            {{ ucfirst($match->result_status ?? 'Pending') }}
                                        </span>
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="{{ route('admin.ballots.create', $match->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Enter Ballot<span class="sr-only">,
                                                {{ $match->id }}</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                        No matches found for this tournament.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection