@extends('layouts.admin')

@section('title', 'Edit Tournament')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black">Edit Tournament</h1>
        <p class="text-black">Update tournament information</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="{{ route('admin.tournaments.update', $tournament) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-black">Tournament Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $tournament->name) }}" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="format" class="block text-sm font-medium text-black">Format</label>
                    <select id="format" name="format" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="asian" {{ $tournament->format == 'asian' ? 'selected' : '' }}>Asian Parliamentary
                        </option>
                        <option value="british" {{ $tournament->format == 'british' ? 'selected' : '' }}>British
                            Parliamentary</option>
                    </select>
                    @error('format')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-black">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ old('start_date', $tournament->start_date?->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-black">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ old('end_date', $tournament->end_date?->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-black">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $tournament->location) }}"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-black">Status</label>
                    <select id="status" name="status" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="upcoming" {{ $tournament->status == 'upcoming' ? 'selected' : '' }}>Upcoming
                        </option>
                        <option value="ongoing" {{ $tournament->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ $tournament->status == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-black">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $tournament->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="{{ route('admin.tournaments.index') }}"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-black shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
                    Update Tournament
                </button>
            </div>
        </form>
    </div>
@endsection
