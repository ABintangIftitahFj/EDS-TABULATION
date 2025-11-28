@extends('layouts.admin')

@section('title', 'Edit Team')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Edit Team</h1>
        <p class="text-slate-500">Update team information and speakers</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="{{ route('admin.teams.update', $team) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="tournament_id" class="block text-sm font-medium text-slate-700">Tournament</label>
                    <select id="tournament_id" name="tournament_id" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Tournament</option>
                        @foreach ($tournaments as $tournament)
                            <option value="{{ $tournament->id }}"
                                {{ $team->tournament_id == $tournament->id ? 'selected' : '' }}>
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tournament_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Team Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="institution" class="block text-sm font-medium text-slate-700">Institution</label>
                    <input type="text" name="institution" id="institution"
                        value="{{ old('institution', $team->institution) }}" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('institution')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Speakers</label>
                    <div id="speakers-container" class="space-y-3">
                        @foreach ($team->speakers as $index => $speaker)
                            <div class="speaker-input flex gap-2">
                                <input type="hidden" name="speakers[{{ $index }}][id]" value="{{ $speaker->id }}">
                                <input type="text" name="speakers[{{ $index }}][name]"
                                    value="{{ $speaker->name }}" placeholder="Speaker {{ $index + 1 }} Name" required
                                    class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @if ($index >= 2)
                                    <button type="button"
                                        class="remove-speaker px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700">Remove</button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-speaker"
                        class="mt-3 inline-flex items-center px-3 py-1.5 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50">
                        + Add Speaker
                    </button>
                    @error('speakers')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="{{ route('admin.teams.index') }}"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Update Team
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let speakerCount = {{ count($team->speakers) }};
        document.getElementById('add-speaker').addEventListener('click', function() {
            const container = document.getElementById('speakers-container');
            const newSpeaker = document.createElement('div');
            newSpeaker.className = 'speaker-input flex gap-2';
            newSpeaker.innerHTML = `
                <input type="text" name="speakers[${speakerCount}][name]" placeholder="Speaker ${speakerCount + 1} Name" required
                    class="flex-1 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <button type="button" class="remove-speaker px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700">Remove</button>
            `;
            container.appendChild(newSpeaker);
            speakerCount++;
        });

        document.getElementById('speakers-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-speaker')) {
                e.target.closest('.speaker-input').remove();
            }
        });
    </script>
@endpush
