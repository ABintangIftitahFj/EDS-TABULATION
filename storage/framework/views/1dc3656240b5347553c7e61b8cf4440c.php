

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-12">
            <div class="min-w-0 flex-1">
                <h2 class="text-4xl font-pixel font-bold leading-tight text-england-blue drop-shadow-sm mb-2">
                    TOURNAMENTS
                </h2>
                <p class="text-lg font-sans text-slate-600 border-l-4 border-soft-pink pl-3">
                    View ongoing and past debate tournaments.
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="/" class="pixel-btn bg-white text-black hover:bg-slate-100 text-sm">
                    🏠 BACK HOME
                </a>
            </div>
        </div>

        <!-- Tournaments Grid -->
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__empty_1 = true; $__currentLoopData = $tournaments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div
                    class="pixel-card relative flex flex-col overflow-hidden bg-white hover:shadow-pixel-lg transition-all duration-300 group h-full">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        <span
                            class="inline-flex items-center px-3 py-1 text-xs font-pixel border-2 border-black shadow-pixel-sm transform rotate-2 <?php echo e($tournament->status === 'ongoing' ? 'bg-green-400 text-black' : 'bg-slate-200 text-slate-600'); ?>">
                            <?php echo e(strtoupper($tournament->status)); ?>

                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <span
                                class="inline-block px-2 py-0.5 text-xs font-pixel bg-england-blue text-white border-2 border-black shadow-sm transform -rotate-1">
                                <?php echo e($tournament->format); ?>

                            </span>
                        </div>

                        <h3
                            class="text-2xl font-pixel font-bold leading-tight text-black mb-3 group-hover:text-england-red transition-colors">
                            <a href="/tournaments/<?php echo e($tournament->id); ?>">
                                <span class="absolute inset-0"></span>
                                <?php echo e($tournament->name); ?>

                            </a>
                        </h3>

                        <p class="mt-2 text-sm text-slate-600 line-clamp-3 font-sans flex-1">
                            <?php echo e($tournament->description ?? 'No description available.'); ?>

                        </p>

                        <div
                            class="mt-6 pt-4 border-t-2 border-slate-100 flex items-center gap-x-4 text-xs font-mono text-slate-500">
                            <div class="flex items-center gap-x-1">
                                <span class="text-lg">📅</span>
                                <?php echo e($tournament->start_date ? $tournament->start_date->format('M d, Y') : 'TBA'); ?>

                            </div>
                            <div class="flex items-center gap-x-1">
                                <span class="text-lg">📍</span>
                                <?php echo e($tournament->location ?? 'Online'); ?>

                            </div>
                        </div>
                    </div>

                    <!-- Hover Effect Footer -->
                    <div
                        class="bg-soft-pink p-2 text-center border-t-2 border-black transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <span class="font-pixel text-england-blue text-sm">VIEW DETAILS →</span>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Empty State -->
                <div class="col-span-full text-center py-16 bg-white pixel-card border-dashed">
                    <div class="inline-block p-6 bg-slate-50 rounded-full border-4 border-slate-200 mb-6">
                        <span class="text-6xl grayscale opacity-50">🏆</span>
                    </div>
                    <h3 class="text-2xl font-pixel text-black mb-2">NO TOURNAMENTS FOUND</h3>
                    <p class="text-base font-sans text-slate-500">Check back later for upcoming events.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\tournaments\index.blade.php ENDPATH**/ ?>