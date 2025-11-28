@extends('layouts.admin')

@section('title', 'Edit Adjudicator')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Edit Adjudicator</h1>
        <p class="text-slate-500">Update adjudicator information</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="{{ route('admin.adjudicators.update', $adjudicator) }}" method="POST">
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
                                {{ $adjudicator->tournament_id == $tournament->id ? 'selected' : '' }}>
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tournament_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $adjudicator->name) }}"
                        required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="institution" class="block text-sm font-medium text-slate-700">Institution</label>
                    <input type="text" name="institution" id="institution"
                        value="{{ old('institution', $adjudicator->institution) }}"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('institution')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rating" class="block text-sm font-medium text-slate-700">Rating (0-10)</label>
                    <input type="number" name="rating" id="rating" value="{{ old('rating', $adjudicator->rating) }}"
                        min="0" max="10" step="0.1"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="{{ route('admin.adjudicators.index') }}"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Update Adjudicator
                </button>
            </div>
        </form>
    </div>
@endsection
