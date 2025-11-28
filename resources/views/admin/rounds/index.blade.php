@extends('layouts.admin')

@section('title', 'Rounds')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Rounds</h1>
            <p class="text-slate-500">Manage tournament rounds and motions</p>
        </div>
        <a href="{{ route('admin.rounds.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
            + Add Round
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
                            Round
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Tournament
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Motion
                        </th>
                        <th class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($rounds as $round)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-900">{{ $round->name }}</div>
                                <div class="text-sm text-slate-500">Round {{ $round->round_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-500">{{ $round->tournament->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-900">{{ $round->motion ?? 'Not set' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.rounds.edit', $round) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.rounds.destroy', $round) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this round?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                No rounds found. <a href="{{ route('admin.rounds.create') }}"
                                    class="text-indigo-600 hover:text-indigo-500">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($rounds->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $rounds->links() }}
            </div>
        @endif
    </div>
@endsection