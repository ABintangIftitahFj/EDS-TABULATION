@extends('layouts.admin')

@section('title', 'Import Data - ' . $tournament->name)

@section('content')
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.tournaments.show', $tournament) }}"
                class="text-black hover:text-black transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-black">Import Data</h1>
                <p class="text-black mt-1">{{ $tournament->name }}</p>
            </div>
        </div>
    </div>

    <!-- Data Summary -->
    <div class="mb-8 bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <h2 class="text-xl font-bold text-black mb-4">📊 Current Data Summary</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $summary['teams'] }}</div>
                <div class="text-sm text-blue-800">Teams</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $summary['speakers'] }}</div>
                <div class="text-sm text-green-800">Speakers</div>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ $summary['adjudicators'] }}</div>
                <div class="text-sm text-purple-800">Adjudicators</div>
            </div>
            <div class="text-center p-4 bg-orange-50 rounded-lg">
                <div class="text-2xl font-bold text-orange-600">{{ $summary['rooms'] }}</div>
                <div class="text-sm text-orange-800">Rooms</div>
            </div>
        </div>
        
        @if($recentImports->isNotEmpty())
        <div class="mt-6">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-semibold text-black">Recent Import Activity</h3>
                <a href="{{ route('admin.tournaments.downloadImportErrors', $tournament) }}" 
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                    📥 Download Errors (CSV)
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left">Entity</th>
                            <th class="px-3 py-2 text-left">Success</th>
                            <th class="px-3 py-2 text-left">Errors</th>
                            <th class="px-3 py-2 text-left">Last Import</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentImports as $entityType => $logs)
                        <tr class="border-t">
                            <td class="px-3 py-2 font-medium">{{ ucfirst($entityType) }}</td>
                            <td class="px-3 py-2 text-green-600">{{ $logs->where('status', 'success')->count() }}</td>
                            <td class="px-3 py-2 text-red-600">{{ $logs->where('status', 'error')->count() }}</td>
                            <td class="px-3 py-2 text-gray-600">{{ $logs->first()->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="mb-6 rounded-lg bg-yellow-50 p-4 text-yellow-800 border border-yellow-200">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <pre class="text-sm whitespace-pre-wrap">{{ session('warning') }}</pre>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-red-800 border border-red-200">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <div>
                    <h4 class="font-semibold mb-2">Errors:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">📄 Upload Instructions</h3>
        <p class="text-blue-800">Upload <strong>tim, speaker, juri, dan room</strong> via CSV. Untuk round dan match, gunakan fitur manual di halaman admin.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Teams Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold">Upload Tim & Speaker</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="font-semibold text-black mb-2">📋 CSV Format:</h4>
                    <pre class="bg-white p-3 rounded text-xs overflow-x-auto">Team Name,Institution,Speaker 1,Speaker 2
Team Alpha,UPI,John Doe,Jane Smith
Team Bravo,ITB,Bob Lee,Alice Wong</pre>
                    <p class="text-xs text-black mt-2">
                        <strong>Required:</strong> Team Name, Institution | <strong>Optional:</strong> Speakers (add more columns)
                    </p>
                </div>

                <div class="flex gap-2">
                    <form action="{{ route('admin.tournaments.processImport', $tournament) }}" method="POST"
                        enctype="multipart/form-data" class="flex-1">
                        @csrf
                        <input type="hidden" name="type" value="teams">
                        <input type="file" name="file" accept=".csv" required class="hidden" id="teams-file">
                        <button type="button" onclick="document.getElementById('teams-file').click()"
                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors mb-2">
                            📁 Upload CSV
                        </button>
                        <button type="submit" id="teams-submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-600 transition-colors hidden">
                            ✅ Process Upload
                        </button>
                    </form>
                </div>
                
                <button onclick="openTeamModal()" class="w-full mt-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-medium hover:bg-blue-200 transition-colors">
                    ➕ Create Manually
                </button>
            </div>
        </div>        <!-- Adjudicators Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="bg-purple-600 px-6 py-4">
                <div class="flex items-center gap-3 text-black">
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
                        <label class="block text-sm font-medium text-black mb-2">CSV File</label>
                        <input type="file" name="file" accept=".csv" required
                            class="block w-full text-sm text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    </div>

                    <div class="mb-4 p-3 bg-purple-50 rounded-lg border border-purple-200">
                        <h4 class="font-semibold text-black mb-2">📋 CSV Format:</h4>
                        <pre class="bg-white p-3 rounded text-xs overflow-x-auto">Name,Institution
    John Doe,Harvard University
    Jane Smith,MIT
    Robert Lee,Stanford</pre>
                        <p class="text-xs text-black mt-2">
                            <strong>Required:</strong> Name, Institution
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-600 text-black px-4 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                        Upload Adjudicators
                    </button>
                </form>
            </div>
        </div>

        <!-- Rooms Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="bg-green-600 px-6 py-4">
                <div class="flex items-center gap-3 text-black">
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
                        <label class="block text-sm font-medium text-black mb-2">CSV File</label>
                        <input type="file" name="file" accept=".csv" required
                            class="block w-full text-sm text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>

                    <div class="mb-4 p-3 bg-green-50 rounded-lg border border-green-200">
                        <h4 class="font-semibold text-black mb-2">📋 CSV Format:</h4>
                        <pre class="bg-white p-3 rounded text-xs overflow-x-auto">Name
    Room A101
    Room B202
    Auditorium 1</pre>
                        <p class="text-xs text-black mt-2">
                            <strong>Required:</strong> Name only
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 text-black px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors">
                        Upload Rooms
                    </button>
                </form>
            </div>
        </div>

        <!-- Rounds Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="bg-orange-600 px-6 py-4">
                <div class="flex items-center gap-3 text-black">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold">Import Rounds</h3>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.tournaments.processImport', $tournament) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="rounds">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-black mb-2">CSV File</label>
                        <input type="file" name="file" accept=".csv" required
                            class="block w-full text-sm text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    </div>

                    <div class="mb-4 p-3 bg-orange-50 rounded-lg border border-orange-200">
                        <h4 class="font-semibold text-black mb-2">📋 CSV Format:</h4>
                        <pre class="bg-white p-3 rounded text-xs overflow-x-auto">Name,Round Number,Type,Motion,Info Slide
    Round 1,1,preliminary,THW ban smoking,
    Round 2,2,preliminary,THW tax sugar,</pre>
                        <p class="text-xs text-black mt-2">
                            <strong>Required:</strong> Name, Round Number
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-orange-600 text-black px-4 py-2 rounded-lg font-medium hover:bg-orange-700 transition-colors">
                        Upload Rounds
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
                        <span>Maximum file size: 2MB</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span><strong>Teams:</strong> Team Name, Institution (required) + Speakers (optional)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span><strong>Adjudicators:</strong> Name, Institution (both required)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span><strong>Rooms:</strong> Name only (required)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>Empty rows will be skipped automatically</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>Errors will be reported with line numbers for easy fixing</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Manual Create Modals -->
    @include('admin.tournaments.modals.team-modal')
    @include('admin.tournaments.modals.adjudicator-modal')
    @include('admin.tournaments.modals.room-modal')
@endsection