@extends('layouts.admin')

@section('title', 'Create Team')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black">Create New Team</h1>
        <p class="text-black">Add a new team to a tournament</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="{{ route('admin.teams.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="tournament_id" class="block text-sm font-medium text-black">Tournament</label>
                    <select id="tournament_id" name="tournament_id" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Tournament</option>
                        @foreach ($tournaments as $tournament)
                            <option value="{{ $tournament->id }}" {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}>
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tournament_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-black">Team Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="institution" class="block text-sm font-medium text-black">Institution</label>
                    <input type="text" name="institution" id="institution" value="{{ old('institution') }}" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('institution')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-black mb-2">Speakers</label>
                    <div id="speakers-container" class="space-y-3">
                        <div class="speaker-input flex gap-2">
                            <input type="text" name="speakers[0][name]" placeholder="Speaker 1 Name" required
                                class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="speaker-input flex gap-2">
                            <input type="text" name="speakers[1][name]" placeholder="Speaker 2 Name" required
                                class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <button type="button" id="add-speaker"
                        class="mt-3 inline-flex items-center px-3 py-1.5 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-black bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        + Add Speaker
                    </button>
                    @error('speakers')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="{{ route('admin.teams.index') }}"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-black shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Create Team
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let speakerCount = 2;
        document.getElementById('add-speaker').addEventListener('click', function () {
            const container = document.getElementById('speakers-container');
            const newSpeaker = document.createElement('div');
            newSpeaker.className = 'speaker-input flex gap-2';
            newSpeaker.innerHTML = `
                    <input type="text" name="speakers[${speakerCount}][name]" placeholder="Speaker ${speakerCount + 1} Name"
                        class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <button type="button" class="remove-speaker px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700">Remove</button>
                `;
            container.appendChild(newSpeaker);
            speakerCount++;
        });

        document.getElementById('speakers-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-speaker')) {
                e.target.closest('.speaker-input').remove();
            }
        });
    </script>
@endpush
