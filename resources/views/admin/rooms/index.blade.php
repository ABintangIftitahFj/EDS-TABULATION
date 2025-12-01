@extends('layouts.admin')

@section('title', 'Rooms')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-black">Rooms</h1>
            <p class="text-black">Manage debate rooms and venues</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
            + Add Room
        </a>
    </div>

    <!-- Tournament Filter -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <form method="GET" action="{{ route('admin.rooms.index') }}" class="flex items-center gap-4">
            <div class="flex-1 max-w-xs">
                <label for="tournament_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Tournament:</label>
                <select id="tournament_id" name="tournament_id" onchange="this.form.submit()"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Tournaments</option>
                    @foreach($tournaments as $tournament)
                        <option value="{{ $tournament->id }}" {{ $tournamentFilter == $tournament->id ? 'selected' : '' }}>
                            {{ $tournament->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if($tournamentFilter)
                <a href="{{ route('admin.rooms.index') }}" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900">
                    Clear Filter
                </a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @forelse($rooms as $room)
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
                <div class="flex items-start justify-between mb-2">
                    <div class="font-semibold text-black text-lg">{{ $room->name }}</div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                        {{ $room->capacity ?? 'N/A' }} 👤
                    </span>
                </div>
                <div class="text-sm text-gray-500 mb-3">
                    📍 {{ $room->location ?? 'N/A' }}
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.rooms.edit', $room) }}"
                        class="flex-1 px-3 py-2 bg-indigo-600 text-white text-center text-sm font-medium rounded-lg hover:bg-indigo-700">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="flex-1"
                        onsubmit="return confirm('Are you sure you want to delete this room?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-3 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-8 text-center">
                <div class="text-4xl mb-2">🏠</div>
                <p class="text-gray-500">No rooms found.</p>
                <a href="{{ route('admin.rooms.create') }}" class="text-indigo-600 hover:text-indigo-500 text-sm">Add one</a>
            </div>
        @endforelse
        
        @if ($rooms->hasPages())
            <div class="mt-4">{{ $rooms->links() }}</div>
        @endif
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Room Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Capacity</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($rooms as $room)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-black">{{ $room->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $room->location ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $room->capacity ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.rooms.edit', $room) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this room?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-black">
                                No rooms found. <a href="{{ route('admin.rooms.create') }}" class="text-indigo-600 hover:text-indigo-500">Add one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($rooms->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $rooms->links() }}
            </div>
        @endif
    </div>
@endsection
