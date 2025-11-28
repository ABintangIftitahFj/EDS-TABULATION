@extends('layouts.admin')

@section('title', 'Import Data - ' . $tournament->name)

@section('content')
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.tournaments.show', $tournament) }}"
                class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Import Data</h1>
                <p class="text-slate-500 mt-1">{{ $tournament->name }}</p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Teams Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold">Import Teams</h3>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.tournaments.processImport', $tournament) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="teams">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">CSV File</label>
                        <input type="file" name="file" accept=".csv" required
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="mb-4 p-3 bg-slate-50 rounded-lg text-xs text-slate-600">
                        <p class="font-semibold mb-1">CSV Format:</p>
                        <code class="block">Team Name,Institution,Speaker 1,Speaker 2,...</code>
                        <p class="mt-2 text-slate-500">Example:</p>
                        <code class="block">Team Alpha,UPI,John Doe,Jane Smith</code>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        Upload Teams
                    </button>
                </form>
            </div>
        </div>

        <!-- Adjudicators Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold">Import Adjudicators</h3>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.tournaments.processImport', $tournament) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="adjudicators">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">CSV File</label>
                        <input type="file" name="file" accept=".csv" required
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    </div>

                    <div class="mb-4 p-3 bg-slate-50 rounded-lg text-xs text-slate-600">
                        <p class="font-semibold mb-1">CSV Format:</p>
                        <code class="block">Name,Institution,Rating</code>
                        <p class="mt-2 text-slate-500">Example:</p>
                        <code class="block">Prof. Smith,Harvard,8.5</code>
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                        Upload Adjudicators
                    </button>
                </form>
            </div>
        </div>

        <!-- Rooms Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="text-lg font-semibold">Import Rooms</h3>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.tournaments.processImport', $tournament) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="rooms">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">CSV File</label>
                        <input type="file" name="file" accept=".csv" required
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>

                    <div class="mb-4 p-3 bg-slate-50 rounded-lg text-xs text-slate-600">
                        <p class="font-semibold mb-1">CSV Format:</p>
                        <code class="block">Room Name,Location,Capacity</code>
                        <p class="mt-2 text-slate-500">Example:</p>
                        <code class="block">Room A101,Building A Floor 1,50</code>
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors">
                        Upload Rooms
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex gap-4">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-semibold text-blue-900 mb-2">Import Instructions</h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>CSV files must have headers in the first row</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>Use comma (,) as delimiter</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>For teams: You can add multiple speakers by adding more columns</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>Rating and capacity fields are optional (can be left empty)</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection