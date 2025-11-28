@extends('layouts.admin')

@section('title', 'Edit Round')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Edit Round</h1>
        <p class="text-slate-500">Update round information and motion</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="{{ route('admin.rounds.update', $round) }}" method="POST">
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
                                {{ $round->tournament_id == $tournament->id ? 'selected' : '' }}>
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tournament_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Round Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $round->name) }}" required
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="round_number" class="block text-sm font-medium text-slate-700">Round Number</label>
                    <input type="number" name="round_number" id="round_number"
                        value="{{ old('round_number', $round->round_number) }}" required min="1"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('round_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="motion" class="block text-sm font-medium text-slate-700">Motion</label>
                    <textarea name="motion" id="motion" rows="3"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('motion', $round->motion) }}</textarea>
                    @error('motion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="info_slide" class="block text-sm font-medium text-slate-700">Info Slide</label>
                    <textarea name="info_slide" id="info_slide" rows="4"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('info_slide', $round->info_slide) }}</textarea>
                    @error('info_slide')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="{{ route('admin.rounds.index') }}"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Update Round
                </button>
            </div>
        </form>
    </div>
@endsection
