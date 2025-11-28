@extends('layouts.admin')

@section('title', 'Motions')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-black">💡 Motions</h1>
            <p class="text-black">View all debate motions from rounds</p>
        </div>
        <a href="{{ route('admin.rounds.index') }}"
            class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
            Manage Rounds
        </a>
    </div>

    @if (session('info'))
        <div class="mb-6 rounded-lg bg-blue-50 p-4 text-blue-800 border border-blue-200">
            {{ session('info') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Tournament
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Round
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Motion
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                            Info Slide
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
                                <div class="text-sm font-medium text-black">{{ $round->tournament->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-black">{{ $round->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-black max-w-md">{{ $round->motion }}</div>
                                @if($round->info_slide)
                                    <div class="text-xs text-black mt-1">{{ Str::limit($round->info_slide, 100) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $round->is_motion_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $round->is_motion_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.rounds.edit', $round) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-black">
                                No motions found. <a href="{{ route('admin.rounds.create') }}"
                                    class="text-indigo-600 hover:text-indigo-500">Create a round with motion</a>
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
