@extends('layouts.admin')

@section('title', 'Motions Management')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
        💡 Motions Management
    </h1>
    <a href="{{ route('admin.motions.create') }}"
        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New Motion
    </a>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                        Round
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                        Motion
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                        Category
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-700 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($motions as $motion)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">
                                {{ $motion->round->name ?? 'N/A' }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $motion->round->tournament->name ?? '' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900 max-w-md">
                                {{ Str::limit($motion->title, 80) }}
                            </div>
                            @if($motion->info_slide)
                                <div class="text-xs text-slate-500 mt-1">
                                    📝 Has info slide
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($motion->category)
                                <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">
                                    {{ $motion->category }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($motion->is_released)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ Released
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    🔒 Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.motions.edit', $motion) }}"
                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.motions.destroy', $motion) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Delete this motion?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <p class="text-lg font-medium mb-2">No motions found</p>
                                <p class="text-sm">Create your first motion to get started</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($motions->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $motions->links() }}
        </div>
    @endif
</div>
@endsection
