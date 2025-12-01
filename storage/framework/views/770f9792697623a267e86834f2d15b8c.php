<?php $__env->startSection('title', 'Enter Ballot'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Enter Ballot: <?php echo e($match->round->title ?? 'Round'); ?>

                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    <?php echo e($match->round->tournament->name ?? 'Tournament'); ?> • <?php echo e($match->room->name ?? 'Room TBA'); ?>

                </p>
            </div>
        </div>

        
        <div class="rounded-md bg-blue-50 p-4 mb-6 border-l-4 border-blue-400">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Scoring Guidelines</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul role="list" class="list-disc space-y-1 pl-5">
                            <li>Speaker Score Range: <strong>69 - 85</strong> (Default: 75)</li>
                            <li>Reply Score Range: <strong>32 - 42</strong> (Default: 36)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <form id="ballotForm" action="<?php echo e(route('admin.ballots.store', $match->id)); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>

            <?php if($match->round->tournament->format === 'british'): ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    
                </div>
            <?php else: ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    
                    <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-indigo-600 mb-4 border-b pb-2 flex justify-between">
                            <span>Government</span>
                            <span class="text-sm text-gray-500 font-normal"><?php echo e($match->govTeam->name); ?></span>
                        </h3>
                        <div class="space-y-5">
                            <?php $__currentLoopData = $match->govTeam->speakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-900"><?php echo e($speaker->name); ?></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" name="scores[<?php echo e($speaker->id); ?>]" value="75" min="69" max="85" step="1"
                                            class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            required>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-400 sm:text-xs">/ 100</span>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Range: 69-85</p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <div class="mt-6 pt-4 border-t border-gray-100 bg-gray-50 -mx-6 px-6 pb-2">
                            <div class="flex items-center mb-2 mt-2">
                                <input type="checkbox" id="gov_reply_check" onchange="toggleReply('gov')"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="gov_reply_check" class="ml-2 block text-sm font-bold text-gray-700">Gov Reply
                                    Speech</label>
                            </div>
                            <div id="gov_reply_input" class="hidden pl-6 border-l-2 border-indigo-200">
                                <label class="block text-sm font-medium text-gray-700">Score</label>
                                <input type="number" name="reply_scores[<?php echo e($match->govTeam->id); ?>]" value="36" min="32" max="42"
                                    step="0.5"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">Range: 32-42</p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-rose-600 mb-4 border-b pb-2 flex justify-between">
                            <span>Opposition</span>
                            <span class="text-sm text-gray-500 font-normal"><?php echo e($match->oppTeam->name); ?></span>
                        </h3>
                        <div class="space-y-5">
                            <?php $__currentLoopData = $match->oppTeam->speakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-900"><?php echo e($speaker->name); ?></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" name="scores[<?php echo e($speaker->id); ?>]" value="75" min="69" max="85" step="1"
                                            class="block w-full rounded-md border-gray-300 focus:border-rose-500 focus:ring-rose-500 sm:text-sm"
                                            required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Range: 69-85</p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <div class="mt-6 pt-4 border-t border-gray-100 bg-gray-50 -mx-6 px-6 pb-2">
                            <div class="flex items-center mb-2 mt-2">
                                <input type="checkbox" id="opp_reply_check" onchange="toggleReply('opp')"
                                    class="h-4 w-4 rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                                <label for="opp_reply_check" class="ml-2 block text-sm font-bold text-gray-700">Opp Reply
                                    Speech</label>
                            </div>
                            <div id="opp_reply_input" class="hidden pl-6 border-l-2 border-rose-200">
                                <label class="block text-sm font-medium text-gray-700">Score</label>
                                <input type="number" name="reply_scores[<?php echo e($match->oppTeam->id); ?>]" value="36" min="32" max="42"
                                    step="0.5"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">Range: 32-42</p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="mt-8 bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Verdict Override (Optional)</h3>
                    <p class="text-sm text-gray-500 mb-4">If left unselected, winner is calculated by total score.</p>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="winner_id" value="<?php echo e($match->govTeam->id); ?>"
                                class="h-5 w-5 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-900 font-medium">Government Win</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="winner_id" value="<?php echo e($match->oppTeam->id); ?>"
                                class="h-5 w-5 text-rose-600 focus:ring-rose-500">
                            <span class="text-gray-900 font-medium">Opposition Win</span>
                        </label>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-6 flex items-center justify-end gap-x-6 pb-10">
                <a href="<?php echo e(route('admin.matches.index')); ?>"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit" id="submitBtn"
                    class="rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Submit Ballot
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleReply(side) {
            const checkbox = document.getElementById(`${side}_reply_check`);
            const inputDiv = document.getElementById(`${side}_reply_input`);

            if (checkbox.checked) {
                inputDiv.classList.remove('hidden');
            } else {
                inputDiv.classList.add('hidden');
            }
        }

        // AJAX Form Submission with Instant UI Update
        document.addEventListener('DOMContentLoaded', function () {
            const ballotForm = document.getElementById('ballotForm');

            if (!ballotForm) {
                console.error('Ballot form not found!');
                return;
            }

            console.log('Ballot form AJAX handler attached');

            ballotForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                console.log('Form submit intercepted by AJAX');

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                // Disable button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Submitting...';

                const formData = new FormData(this);
                const url = this.action;

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        // INSTANT UPDATE: Update parent window button BEFORE showing success message
                        if (window.parent && window.parent.document) {
                            try {
                                // Find the match ID from URL
                                const matchId = '<?php echo e($match->id); ?>';

                                // Find the button in parent window and update it immediately
                                const parentButtons = window.parent.document.querySelectorAll(`button[onclick*="openScoreModal"][onclick*="${matchId}"]`);
                                parentButtons.forEach(btn => {
                                    // Change to green background and "Score Terisi" text
                                    btn.className = btn.className.replace('bg-indigo-600', 'bg-green-600');
                                    btn.className = btn.className.replace('hover:bg-indigo-700', 'hover:bg-green-700');
                                    btn.className = btn.className.replace('bg-amber-600', 'bg-green-600');
                                    btn.className = btn.className.replace('hover:bg-amber-700', 'hover:bg-green-700');
                                    btn.innerHTML = '✅ Score Terisi';

                                    // Add pulsing indicator
                                    if (!btn.querySelector('.animate-ping')) {
                                        const indicator = document.createElement('span');
                                        indicator.className = 'absolute -top-1 -right-1 flex h-3 w-3';
                                        indicator.innerHTML = '<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>';
                                        btn.parentElement.style.position = 'relative';
                                        btn.parentElement.appendChild(indicator);
                                    }
                                });
                            } catch (e) {
                                console.log('Could not update parent button immediately:', e);
                            }
                        }

                        // Show success message
                        await Swal.fire({
                            title: 'Berhasil! 🎉',
                            text: data.message || 'Ballot berhasil disimpan!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#4F46E5',
                            timer: 2000
                        });

                        // Redirect to Manage Tournament Draw Tab
                        const tournamentId = '<?php echo e($match->round->tournament_id); ?>';
                        const redirectUrl = `/admin/tournaments/${tournamentId}#draw-tab`;

                        if (window.parent && window.parent !== window) {
                            // Close modal first
                            if (window.parent.closeScoreModal) {
                                window.parent.closeScoreModal();
                            }
                            // Redirect parent window to Draw tab
                            window.parent.location.href = redirectUrl;
                        } else {
                            // If not in iframe, just redirect
                            window.location.href = redirectUrl;
                        }
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Terjadi kesalahan saat menyimpan ballot.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });

                        // Re-enable button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan ballot.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        }); // End DOMContentLoaded
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/admin/ballots/create.blade.php ENDPATH**/ ?>