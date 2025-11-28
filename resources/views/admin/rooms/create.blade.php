@extends('layouts.admin')

@section('title', 'Create Room')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Add New Room</h1>
        <p class="text-slate-500">Register a new debate room or venue</p>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <form action="{{ route('admin.rooms.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Room Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="e.g., Room A101"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-slate-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                        placeholder="e.g., Building A, 1st Floor"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-medium text-slate-700">Capacity</label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="1"
                        placeholder="e.g., 50"
                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <p class="mt-1 text-sm text-slate-500">Optional: Maximum number of people</p>
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="{{ route('admin.rooms.index') }}"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Add Room
                </button>
            </div>
        </form>
    </div>
@endsection