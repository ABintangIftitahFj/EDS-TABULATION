@extends('layouts.admin')

@section('title', 'Manage Tournaments')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Tournaments</h1>
            <p class="text-slate-500">Manage all debate tournaments</p>
        </div>
        <a href="{{ route('admin.tournaments.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
            + Add Tournament
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Format
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($tournaments as $tournament)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-900">{{ $tournament->name }}</div>
                                <div class="text-sm text-slate-500">{{ $tournament->location }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-500">{{ ucfirst(str_replace('_', ' ', $tournament->format)) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $tournament->status === 'ongoing' ? 'bg-green-100 text-green-800' : ($tournament->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800') }}">
                                    {{ ucfirst($tournament->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-500">
                                    {{ $tournament->start_date ? $tournament->start_date->format('M d, Y') : 'TBA' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.tournaments.show', $tournament) }}"
                                    class="text-green-600 hover:text-green-900 mr-3">Manage</a>
                                <a href="{{ route('admin.tournaments.edit', $tournament) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.tournaments.destroy', $tournament) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this tournament?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                No tournaments found. <a href="{{ route('admin.tournaments.create') }}"
                                    class="text-indigo-600 hover:text-indigo-500">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($tournaments->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $tournaments->links() }}
            </div>
        @endif
    </div>
@endsection