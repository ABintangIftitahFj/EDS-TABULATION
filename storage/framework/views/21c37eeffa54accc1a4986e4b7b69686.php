

<?php $__env->startSection('title', 'Speakers List - ' . $tournament->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                🎤 SPEAKER LIST: <?php echo e($tournament->name); ?>

            </h1>
        </div>

        
        <div class="border-b-4 border-slate-200 mb-8 overflow-x-auto pb-1">
            <nav class="-mb-1 flex space-x-8 min-w-max" aria-label="Tabs">
                <a href="/tournaments" class="pixel-tab text-slate-600 hover:text-black">
                    ← ALL TOURNAMENTS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>" class="pixel-tab text-slate-600 hover:text-black">
                    🏠 OVERVIEW
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/motions" class="pixel-tab text-slate-600 hover:text-black">
                    💡 MOTIONS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/standings" class="pixel-tab text-slate-600 hover:text-black">
                    🏆 STANDINGS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/matches" class="pixel-tab text-slate-600 hover:text-black">
                    ⚔️ MATCHES & DRAW
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/results" class="pixel-tab text-slate-600 hover:text-black">
                    📊 RESULTS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/speakers" class="pixel-tab text-slate-600 hover:text-black">
                    🎤 SPEAKERS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/adjudicators" class="pixel-tab text-slate-600 hover:text-black">
                    ⚖️ ADJUDICATORS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/participants" class="pixel-tab pixel-tab-active">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        
        <div class="pixel-card overflow-hidden bg-white">
            <div class="px-6 py-4 border-b-4 border-slate-900 bg-england-red flex justify-between items-center">
                <h2 class="text-2xl font-pixel text-white">SPEAKER LIST</h2>
                <?php
                    $allSpeakers = $tournament->teams->flatMap->speakers;
                ?>
                <span class="px-3 py-1 bg-white text-england-red text-sm font-pixel border-2 border-black shadow-pixel-sm">
                    <?php echo e($allSpeakers->count()); ?> SPEAKERS
                </span>
            </div>

            <?php if($allSpeakers->count() > 0): ?>
                
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-slate-900">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">#</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Name</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider">Institution</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y-2 divide-slate-100">
                            <?php $__currentLoopData = $allSpeakers->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-red-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="w-8 h-8 bg-england-red/10 border-2 border-england-red/30 flex items-center justify-center rounded">
                                            <span class="text-england-red font-pixel text-sm"><?php echo e($index + 1); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-england-red border-2 border-black shadow-pixel-sm flex items-center justify-center">
                                                <span class="text-white font-pixel text-lg"><?php echo e(strtoupper(substr($speaker->name, 0, 1))); ?></span>
                                            </div>
                                            <span class="text-lg font-bold font-sans text-black"><?php echo e($speaker->name); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-600 font-sans"><?php echo e($speaker->team->institution ?? '-'); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="md:hidden divide-y divide-slate-200">
                    <?php $__currentLoopData = $allSpeakers->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-4 hover:bg-red-50/50 flex items-center gap-3">
                            <div class="w-8 h-8 bg-england-red/10 border-2 border-england-red/30 flex items-center justify-center rounded flex-shrink-0">
                                <span class="text-england-red font-pixel text-sm"><?php echo e($index + 1); ?></span>
                            </div>
                            <div class="w-10 h-10 bg-england-red border-2 border-black shadow-pixel-sm flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-pixel text-lg"><?php echo e(strtoupper(substr($speaker->name, 0, 1))); ?></span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base font-bold font-sans text-black truncate"><?php echo e($speaker->name); ?></h3>
                                <p class="text-sm text-slate-600"><?php echo e($speaker->team->institution ?? '-'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 border-2 border-slate-300 flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">🎤</span>
                    </div>
                    <p class="text-xl font-pixel text-slate-500">No speakers yet</p>
                    <p class="text-slate-400 mt-2">Speakers will appear here once teams are added.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/tournaments/participants.blade.php ENDPATH**/ ?>