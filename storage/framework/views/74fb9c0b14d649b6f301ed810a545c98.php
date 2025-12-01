

<?php $__env->startSection('title', 'Adjudicator Reviews - Match #' . $match->id); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="<?php echo e(route('admin.matches.index')); ?>" class="text-black hover:text-black transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-black">Adjudicator Reviews</h1>
                <p class="text-black mt-1">
                    <?php echo e($match->govTeam->name); ?> vs <?php echo e($match->oppTeam->name); ?> • Round <?php echo e($match->round->name); ?>

                </p>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Match Info Card -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-sm font-medium text-black mb-2">Government Team</h3>
                <p class="text-lg font-bold text-blue-600"><?php echo e($match->govTeam->name); ?></p>
                <p class="text-sm text-black"><?php echo e($match->govTeam->institution); ?></p>
            </div>
            <div class="text-center">
                <h3 class="text-sm font-medium text-black mb-2">VS</h3>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        <?php echo e($match->status === 'finished' ? 'bg-green-100 text-green-800' : ($match->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-black')); ?>">
                    <?php echo e(ucfirst(str_replace('_', ' ', $match->status))); ?>

                </span>
            </div>
            <div class="text-right">
                <h3 class="text-sm font-medium text-black mb-2">Opposition Team</h3>
                <p class="text-lg font-bold text-purple-600"><?php echo e($match->oppTeam->name); ?></p>
                <p class="text-sm text-black"><?php echo e($match->oppTeam->institution); ?></p>
            </div>
        </div>

        <?php if($match->status === 'finished'): ?>
            <div class="mt-6 pt-6 border-t border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <p class="text-sm text-black mb-1">Final Score (Gov)</p>
                        <p class="text-3xl font-bold text-blue-600"><?php echo e(number_format($match->final_score_team_a, 2)); ?></p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-black mb-1">Winner</p>
                        <p class="text-2xl font-bold text-green-600">
                            <?php echo e($match->winnerTeam ? $match->winnerTeam->name : 'Draw'); ?>

                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-black mb-1">Final Score (Opp)</p>
                        <p class="text-3xl font-bold text-purple-600"><?php echo e(number_format($match->final_score_team_b, 2)); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Existing Reviews -->
    <?php if($existingReviews->count() > 0): ?>
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 mb-6">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                <h3 class="text-lg font-semibold text-black">Submitted Reviews
                    (<?php echo e($existingReviews->count()); ?>)</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php $__currentLoopData = $existingReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-slate-200 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="bg-indigo-100 rounded-lg p-2">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-black"><?php echo e($review->adjudicator->name); ?></h4>
                                            <p class="text-sm text-black"><?php echo e($review->adjudicator->institution); ?></p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="bg-blue-50 rounded-lg p-3">
                                            <p class="text-xs text-blue-600 font-medium mb-1">Gov Score</p>
                                            <p class="text-2xl font-bold text-blue-700"><?php echo e($review->score_team_a); ?></p>
                                        </div>
                                        <div class="bg-purple-50 rounded-lg p-3">
                                            <p class="text-xs text-purple-600 font-medium mb-1">Opp Score</p>
                                            <p class="text-2xl font-bold text-purple-700"><?php echo e($review->score_team_b); ?></p>
                                        </div>
                                    </div>
                                    <?php if($review->comment): ?>
                                        <div class="bg-slate-50 rounded-lg p-3">
                                            <p class="text-sm text-black"><?php echo e($review->comment); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <form action="<?php echo e(route('admin.adjudicator-reviews.destroy', $review)); ?>" method="POST"
                                    onsubmit="return confirm('Delete this review?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="ml-4 text-red-600 hover:text-red-800 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Add New Review Form -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-black">Add Adjudicator Review</h3>
        </div>
        <div class="p-6">
            <form action="<?php echo e(route('admin.adjudicator-reviews.store', $match)); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="space-y-6">
                    <div>
                        <label for="adjudicator_id" class="block text-sm font-medium text-black">Adjudicator</label>
                        <select id="adjudicator_id" name="adjudicator_id" required
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Adjudicator</option>
                            <?php $__currentLoopData = $adjudicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($adj->id); ?>" <?php echo e(old('adjudicator_id') == $adj->id ? 'selected' : ''); ?>>
                                    <?php echo e($adj->name); ?> - <?php echo e($adj->institution); ?>

                                    <?php if($adj->rating): ?>
                                        (Rating: <?php echo e($adj->rating); ?>)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['adjudicator_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="score_team_a" class="block text-sm font-medium text-black">
                                Score for <?php echo e($match->govTeam->name); ?> (Gov)
                            </label>
                            <input type="number" name="score_team_a" id="score_team_a" value="<?php echo e(old('score_team_a')); ?>"
                                required min="0" max="100" step="0.01"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <?php $__errorArgs = ['score_team_a'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="score_team_b" class="block text-sm font-medium text-black">
                                Score for <?php echo e($match->oppTeam->name); ?> (Opp)
                            </label>
                            <input type="number" name="score_team_b" id="score_team_b" value="<?php echo e(old('score_team_b')); ?>"
                                required min="0" max="100" step="0.01"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <?php $__errorArgs = ['score_team_b'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div>
                        <label for="comment" class="block text-sm font-medium text-black">Comment (Optional)</label>
                        <textarea name="comment" id="comment" rows="4"
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Feedback on team performance..."><?php echo e(old('comment')); ?></textarea>
                        <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-3">
                    <a href="<?php echo e(route('admin.matches.index')); ?>"
                        class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-black shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                        Back to Matches
                    </a>
                    <button type="submit"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\admin\adjudicator-reviews\create.blade.php ENDPATH**/ ?>