@extends('layouts.admin')

@section('title', 'Teams')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-black">Teams</h1>
            <p class="text-black">Manage tournament teams and speakers</p>
        </div>
        <a href="{{ route('admin.teams.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            + Add Team
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
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Team Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Institution
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Tournament
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Speakers
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Points
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($teams as $team)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-black">{{ $team->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $team->institution }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $team->tournament->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-black">
                                    @foreach ($team->speakers as $speaker)
                                        <div>{{ $speaker->name }}</div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-black">{{ $team->total_points ?? 0 }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.teams.edit', $team) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this team?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-black">
                                No teams found. <a href="{{ route('admin.teams.create') }}"
                                    class="text-indigo-600 hover:text-indigo-500">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($teams->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $teams->links() }}
            </div>
        @endif
    </div>
@endsection
