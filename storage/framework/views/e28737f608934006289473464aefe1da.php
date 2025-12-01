

<?php $__env->startSection('title', 'Import Data - ' . $tournament->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="<?php echo e(route('admin.tournaments.show', $tournament)); ?>"
                class="text-black hover:text-black transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-black">Import Data</h1>
                <p class="text-black mt-1"><?php echo e($tournament->name); ?></p>
            </div>
        </div>
    </div>

    <!-- Data Summary -->
    <div id="data-summary" class="mb-8 bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6">
        <h2 class="text-xl font-bold text-black mb-4">📊 Current Data Summary</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div id="count-teams" class="text-2xl font-bold text-blue-600"><?php echo e($summary['teams']); ?></div>
                <div class="text-sm text-blue-800">Teams</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div id="count-speakers" class="text-2xl font-bold text-green-600"><?php echo e($summary['speakers']); ?></div>
                <div class="text-sm text-green-800">Speakers</div>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div id="count-adjudicators" class="text-2xl font-bold text-purple-600"><?php echo e($summary['adjudicators']); ?></div>
                <div class="text-sm text-purple-800">Adjudicators</div>
            </div>
            <div class="text-center p-4 bg-amber-50 rounded-lg">
                <div id="count-rooms" class="text-2xl font-bold text-amber-600"><?php echo e($summary['rooms']); ?></div>
                <div class="text-sm text-amber-800">Rooms</div>
            </div>
            <div class="text-center p-4 bg-orange-50 rounded-lg">
                <div id="count-rounds" class="text-2xl font-bold text-orange-600"><?php echo e($summary['rounds']); ?></div>
                <div class="text-sm text-orange-800">Rounds</div>
            </div>
        </div>
    </div>

    <!-- Global Messages -->
    <div id="global-messages"></div>

    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">📄 Upload Instructions</h3>
        <p class="text-blue-800">Upload <strong>tim, speaker, juri, room, dan round</strong> via CSV. File yang sudah dipilih di card lain tidak akan hilang saat upload.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Teams Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden" id="card-teams">
            <div class="bg-blue-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold">Teams & Speakers</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-black mb-2">CSV File</label>
                    <div class="relative">
                        <input type="file" id="file-teams" accept=".csv" 
                            class="block w-full text-sm text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div id="filename-teams" class="mt-2 text-sm text-blue-600 font-medium hidden">
                        <span class="flex items-center gap-1">📄 <span class="name"></span></span>
                    </div>
                </div>

                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="font-semibold text-black mb-2 text-sm">📋 Format:</h4>
                    <pre class="bg-white p-2 rounded text-xs overflow-x-auto">Team Name,Institution,Speaker 1,Speaker 2</pre>
                </div>

                <!-- Status Message -->
                <div id="status-teams" class="mb-3 hidden"></div>

                <button type="button" onclick="uploadFile('teams')" id="btn-teams"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span class="btn-text">Upload Teams</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        <!-- Adjudicators Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden" id="card-adjudicators">
            <div class="bg-purple-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold">Adjudicators</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-black mb-2">CSV File</label>
                    <input type="file" id="file-adjudicators" accept=".csv"
                        class="block w-full text-sm text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    <div id="filename-adjudicators" class="mt-2 text-sm text-purple-600 font-medium hidden">
                        <span class="flex items-center gap-1">📄 <span class="name"></span></span>
                    </div>
                </div>

                <div class="mb-4 p-3 bg-purple-50 rounded-lg border border-purple-200">
                    <h4 class="font-semibold text-black mb-2 text-sm">📋 Format:</h4>
                    <pre class="bg-white p-2 rounded text-xs overflow-x-auto">Name,Institution</pre>
                </div>

                <div id="status-adjudicators" class="mb-3 hidden"></div>

                <button type="button" onclick="uploadFile('adjudicators')" id="btn-adjudicators"
                    class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span class="btn-text">Upload Adjudicators</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        <!-- Rooms Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden" id="card-rooms">
            <div class="bg-green-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="text-lg font-semibold">Rooms</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-black mb-2">CSV File</label>
                    <input type="file" id="file-rooms" accept=".csv"
                        class="block w-full text-sm text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <div id="filename-rooms" class="mt-2 text-sm text-green-600 font-medium hidden">
                        <span class="flex items-center gap-1">📄 <span class="name"></span></span>
                    </div>
                </div>

                <div class="mb-4 p-3 bg-green-50 rounded-lg border border-green-200">
                    <h4 class="font-semibold text-black mb-2 text-sm">📋 Format:</h4>
                    <pre class="bg-white p-2 rounded text-xs overflow-x-auto">Name</pre>
                </div>

                <div id="status-rooms" class="mb-3 hidden"></div>

                <button type="button" onclick="uploadFile('rooms')" id="btn-rooms"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span class="btn-text">Upload Rooms</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        <!-- Rounds Import -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 overflow-hidden" id="card-rounds">
            <div class="bg-orange-600 px-6 py-4">
                <div class="flex items-center gap-3 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold">Rounds</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-black mb-2">CSV File</label>
                    <input type="file" id="file-rounds" accept=".csv"
                        class="block w-full text-sm text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    <div id="filename-rounds" class="mt-2 text-sm text-orange-600 font-medium hidden">
                        <span class="flex items-center gap-1">📄 <span class="name"></span></span>
                    </div>
                </div>

                <div class="mb-4 p-3 bg-orange-50 rounded-lg border border-orange-200">
                    <h4 class="font-semibold text-black mb-2 text-sm">📋 Format:</h4>
                    <pre class="bg-white p-2 rounded text-xs overflow-x-auto">Name,Round Number,Motion,Info Slide</pre>
                    <p class="text-xs text-gray-600 mt-1">Motion & Info Slide optional</p>
                </div>

                <div id="status-rounds" class="mb-3 hidden"></div>

                <button type="button" onclick="uploadFile('rounds')" id="btn-rounds"
                    class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-orange-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span class="btn-text">Upload Rounds</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
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
                        <span><strong>Teams:</strong> Team Name, Institution (required) + Speakers (optional columns)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span><strong>Adjudicators:</strong> Name, Institution (both required)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span><strong>Rooms:</strong> Name only (required)</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const tournamentId = <?php echo e($tournament->id); ?>;
        const uploadUrl = "<?php echo e(route('admin.tournaments.processImport', $tournament)); ?>";
        const csrfToken = "<?php echo e(csrf_token()); ?>";

        // Store selected files
        const selectedFiles = {
            teams: null,
            adjudicators: null,
            rooms: null,
            rounds: null
        };

        // Listen for file selection
        ['teams', 'adjudicators', 'rooms', 'rounds'].forEach(type => {
            const fileInput = document.getElementById(`file-${type}`);
            const filenameDiv = document.getElementById(`filename-${type}`);
            
            fileInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    selectedFiles[type] = this.files[0];
                    filenameDiv.classList.remove('hidden');
                    filenameDiv.querySelector('.name').textContent = this.files[0].name;
                } else {
                    selectedFiles[type] = null;
                    filenameDiv.classList.add('hidden');
                }
            });
        });

        async function uploadFile(type) {
            const fileInput = document.getElementById(`file-${type}`);
            const btn = document.getElementById(`btn-${type}`);
            const statusDiv = document.getElementById(`status-${type}`);
            
            if (!fileInput.files.length) {
                showStatus(type, 'error', 'Please select a CSV file first');
                return;
            }

            const file = fileInput.files[0];
            
            // Show loading state
            btn.disabled = true;
            btn.querySelector('.btn-text').classList.add('hidden');
            btn.querySelector('.btn-loading').classList.remove('hidden');
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', type);
            formData.append('_token', csrfToken);

            try {
                const response = await fetch(uploadUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    showStatus(type, 'success', data.message || 'Upload successful!');
                    // Update counts if provided
                    if (data.counts) {
                        updateCounts(data.counts);
                    }
                    // Clear the file input after successful upload
                    fileInput.value = '';
                    document.getElementById(`filename-${type}`).classList.add('hidden');
                    selectedFiles[type] = null;
                } else {
                    showStatus(type, 'error', data.message || 'Upload failed');
                }
            } catch (error) {
                console.error('Upload error:', error);
                showStatus(type, 'error', 'Upload failed. Please try again.');
            } finally {
                // Reset button state
                btn.disabled = false;
                btn.querySelector('.btn-text').classList.remove('hidden');
                btn.querySelector('.btn-loading').classList.add('hidden');
            }
        }

        function showStatus(type, status, message) {
            const statusDiv = document.getElementById(`status-${type}`);
            statusDiv.classList.remove('hidden');
            
            if (status === 'success') {
                statusDiv.className = 'mb-3 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200 text-sm';
                statusDiv.innerHTML = `<div class="flex items-center gap-2">✅ ${message}</div>`;
            } else {
                statusDiv.className = 'mb-3 p-3 rounded-lg bg-red-50 text-red-800 border border-red-200 text-sm';
                statusDiv.innerHTML = `<div class="flex items-center gap-2">❌ ${message}</div>`;
            }

            // Auto-hide success messages after 5 seconds
            if (status === 'success') {
                setTimeout(() => {
                    statusDiv.classList.add('hidden');
                }, 5000);
            }
        }

        function updateCounts(counts) {
            if (counts.teams !== undefined) {
                document.getElementById('count-teams').textContent = counts.teams;
            }
            if (counts.speakers !== undefined) {
                document.getElementById('count-speakers').textContent = counts.speakers;
            }
            if (counts.adjudicators !== undefined) {
                document.getElementById('count-adjudicators').textContent = counts.adjudicators;
            }
            if (counts.rooms !== undefined) {
                document.getElementById('count-rooms').textContent = counts.rooms;
            }
            if (counts.rounds !== undefined) {
                document.getElementById('count-rounds').textContent = counts.rounds;
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\admin\tournaments\import.blade.php ENDPATH**/ ?>