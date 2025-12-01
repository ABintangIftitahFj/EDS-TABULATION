

<?php $__env->startSection('title', 'Adjudicators - ' . $tournament->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                ⚖️ ADJUDICATORS: <?php echo e($tournament->name); ?>

            </h1>
        </div>

        
        <div class="border-b-4 border-slate-200 mb-8 overflow-x-auto pb-1">
            <nav class="-mb-1 flex space-x-8 min-w-max" aria-label="Tabs">
                <a href="/tournaments"
                    class="pixel-tab text-slate-600 hover:text-black">
                    ← ALL TOURNAMENTS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>"
                    class="pixel-tab text-slate-600 hover:text-black">
                    🏠 OVERVIEW
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/motions"
                    class="pixel-tab text-slate-600 hover:text-black">
                    💡 MOTIONS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/standings"
                    class="pixel-tab text-slate-600 hover:text-black">
                    🏆 STANDINGS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/matches"
                    class="pixel-tab text-slate-600 hover:text-black">
                    ⚔️ MATCHES & DRAW
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/results"
                    class="pixel-tab text-slate-600 hover:text-black">
                    📊 RESULTS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/speakers"
                    class="pixel-tab text-slate-600 hover:text-black">
                    🎤 SPEAKERS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/adjudicators"
                    class="pixel-tab pixel-tab-active">
                    ⚖️ ADJUDICATORS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/participants"
                    class="pixel-tab text-slate-600 hover:text-black">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        
        <div class="pixel-card overflow-hidden bg-white">
            <div class="px-6 py-4 border-b-4 border-slate-900 bg-purple-600 flex justify-between items-center">
                <h2 class="text-2xl font-pixel text-white">ADJUDICATOR LIST</h2>
                <span class="px-3 py-1 bg-white text-purple-600 text-sm font-pixel border-2 border-black shadow-pixel-sm">
                    <?php echo e($tournament->adjudicators->count()); ?> ADJUDICATORS
                </span>
            </div>

            <?php if($tournament->adjudicators->count() > 0): ?>
                
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-slate-900">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">#</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Name</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Institution</th>
                                <th class="px-6 py-3 text-center text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Rating</th>
                                <th class="px-6 py-3 text-center text-lg font-pixel text-black tracking-wider">Role</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y-2 divide-slate-100">
                            <?php $__currentLoopData = $tournament->adjudicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $adjudicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-purple-50/50 transition-colors">
                                    
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="w-8 h-8 bg-purple-100 border-2 border-purple-300 flex items-center justify-center rounded">
                                            <span class="text-purple-600 font-pixel text-lg"><?php echo e($index + 1); ?></span>
                                        </div>
                                    </td>

                                    
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-purple-600 border-2 border-black shadow-pixel-sm flex items-center justify-center">
                                                <span class="text-white font-pixel text-lg"><?php echo e(strtoupper(substr($adjudicator->name, 0, 1))); ?></span>
                                            </div>
                                            <span class="ml-3 text-lg font-pixel text-black"><?php echo e($adjudicator->name); ?></span>
                                        </div>
                                    </td>

                                    
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <span class="text-base text-slate-600 font-sans"><?php echo e($adjudicator->institution ?? '-'); ?></span>
                                    </td>

                                    
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <?php
                                                $rating = $adjudicator->rating ?? 0;
                                                $stars = round($rating);
                                            ?>
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= $stars): ?>
                                                    <span class="text-yellow-400 text-lg">★</span>
                                                <?php else: ?>
                                                    <span class="text-slate-300 text-lg">★</span>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <span class="ml-2 text-sm font-pixel text-slate-600">(<?php echo e(number_format($rating, 1)); ?>)</span>
                                        </div>
                                    </td>

                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <?php if($adjudicator->is_chair ?? false): ?>
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-pixel border-2 border-yellow-300">
                                                CHAIR
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-sm font-pixel border-2 border-slate-300">
                                                PANELIST
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="md:hidden divide-y divide-slate-200">
                    <?php $__currentLoopData = $tournament->adjudicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $adjudicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-4 hover:bg-purple-50/50">
                            <div class="flex items-start gap-3">
                                <div class="w-12 h-12 bg-purple-600 border-2 border-black shadow-pixel-sm flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-pixel text-xl"><?php echo e(strtoupper(substr($adjudicator->name, 0, 1))); ?></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs bg-purple-100 text-purple-600 px-2 py-0.5 font-pixel border border-purple-300">#<?php echo e($index + 1); ?></span>
                                        <?php if($adjudicator->is_chair ?? false): ?>
                                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 font-pixel border border-yellow-300">CHAIR</span>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="text-lg font-pixel text-black mt-1"><?php echo e($adjudicator->name); ?></h3>
                                    <p class="text-sm text-slate-600"><?php echo e($adjudicator->institution ?? '-'); ?></p>
                                    
                                    
                                    <div class="flex items-center gap-1 mt-2">
                                        <?php
                                            $rating = $adjudicator->rating ?? 0;
                                            $stars = round($rating);
                                        ?>
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $stars): ?>
                                                <span class="text-yellow-400">★</span>
                                            <?php else: ?>
                                                <span class="text-slate-300">★</span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span class="ml-1 text-xs font-pixel text-slate-600">(<?php echo e(number_format($rating, 1)); ?>)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 border-2 border-slate-300 flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">⚖️</span>
                    </div>
                    <p class="text-xl font-pixel text-slate-500">No adjudicators yet</p>
                    <p class="text-slate-400 mt-2">Adjudicators will appear here once they are added to the tournament.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/tournaments/adjudicators.blade.php ENDPATH**/ ?>