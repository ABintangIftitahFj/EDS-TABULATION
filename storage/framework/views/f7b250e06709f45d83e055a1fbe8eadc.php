

<?php $__env->startSection('title', 'Speakers - ' . $tournament->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                🎤 SPEAKERS: <?php echo e($tournament->name); ?>

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
                    class="pixel-tab pixel-tab-active">
                    🎤 SPEAKERS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/adjudicators"
                    class="pixel-tab text-slate-600 hover:text-black">
                    ⚖️ ADJUDICATORS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/participants"
                    class="pixel-tab text-slate-600 hover:text-black">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        
        <div class="pixel-card overflow-hidden bg-white">
            <div class="px-6 py-4 border-b-4 border-slate-900 bg-england-red flex justify-between items-center">
                <h2 class="text-2xl font-pixel text-white">INDIVIDUAL RANKINGS</h2>
                <span class="px-3 py-1 bg-white text-england-red text-sm font-pixel border-2 border-black shadow-pixel-sm">
                    <?php echo e($speakers->count()); ?> SPEAKERS
                </span>
            </div>

            <?php if($speakers->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-slate-900">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Rank</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Speaker</th>
                                <th class="px-6 py-3 text-left text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Team & Institution</th>
                                <?php if($hasPublishedResults): ?>
                                    <th class="px-6 py-3 text-center text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Total Points</th>
                                    <th class="px-6 py-3 text-center text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Speeches</th>
                                    <th class="px-6 py-3 text-center text-lg font-pixel text-black tracking-wider border-r-2 border-slate-300">Avg</th>
                                    <th class="px-6 py-3 text-center text-lg font-pixel text-black tracking-wider">Highest</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y-2 divide-slate-100">
                            <?php $__currentLoopData = $speakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-soft-pink/10 transition-colors <?php echo e($hasPublishedResults && $speaker->rank <= 3 ? 'bg-yellow-50' : ''); ?>">
                                    
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="flex items-center">
                                            <?php if($hasPublishedResults): ?>
                                                <?php if($speaker->rank == 1): ?>
                                                    <div class="w-10 h-10 bg-yellow-400 border-2 border-black shadow-pixel-sm flex items-center justify-center transform -rotate-3">
                                                        <span class="text-2xl">🥇</span>
                                                    </div>
                                                <?php elseif($speaker->rank == 2): ?>
                                                    <div class="w-10 h-10 bg-slate-300 border-2 border-black shadow-pixel-sm flex items-center justify-center transform rotate-2">
                                                        <span class="text-2xl">🥈</span>
                                                    </div>
                                                <?php elseif($speaker->rank == 3): ?>
                                                    <div class="w-10 h-10 bg-amber-600 border-2 border-black shadow-pixel-sm flex items-center justify-center transform -rotate-1">
                                                        <span class="text-2xl">🥉</span>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="w-8 h-8 bg-slate-100 border-2 border-slate-300 flex items-center justify-center rounded">
                                                        <span class="text-slate-600 font-pixel text-lg"><?php echo e($speaker->rank); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <span class="ml-4 text-lg font-pixel text-black">#<?php echo e($speaker->rank); ?></span>
                                            <?php else: ?>
                                                <div class="w-8 h-8 bg-slate-100 border-2 border-slate-300 flex items-center justify-center rounded">
                                                    <span class="text-slate-400 font-pixel text-lg">-</span>
                                                </div>
                                                <span class="ml-4 text-lg font-pixel text-slate-400">Hidden</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-slate-100">
                                        <div class="flex flex-col">
                                            <div class="text-base font-bold font-sans text-black"><?php echo e($speaker->name); ?></div>
                                            <?php if($hasPublishedResults && $speaker->rank <= 3): ?>
                                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-pixel bg-purple-100 text-purple-800 border border-purple-300 w-max">
                                                    <?php echo e($speaker->rank == 1 ? 'BEST SPEAKER' : ($speaker->rank == 2 ? '2ND BEST' : '3RD BEST')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    
                                    <td class="px-6 py-4 border-r border-slate-100">
                                        <div class="text-sm font-medium text-black font-sans"><?php echo e($speaker->team->emoji ?? '👥'); ?> <?php echo e($speaker->team->name ?? 'Unknown Team'); ?></div>
                                        <div class="text-xs text-slate-500 font-mono mt-1"><?php echo e($speaker->team->institution ?? 'Unknown Institution'); ?></div>
                                    </td>

                                    <?php if($hasPublishedResults): ?>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                            <span class="inline-block px-3 py-1 bg-england-blue text-white font-pixel text-lg border-2 border-black shadow-sm">
                                                <?php echo e($speaker->total_score ?? 0); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                            <div class="text-base font-bold font-mono text-black"><?php echo e($speaker->ballots_count ?? 0); ?></div>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                            <div class="text-base font-bold font-mono text-black">
                                                <?php echo e($speaker->ballots_count > 0 ? number_format(($speaker->total_score ?? 0) / $speaker->ballots_count, 1) : '0.0'); ?>

                                            </div>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-base font-bold font-mono text-england-red">
                                                <?php
                                                    $scores = [];
                                                    if ($speaker->ballots ?? false) {
                                                        $scores = $speaker->ballots->pluck('score')->toArray();
                                                    }
                                                    $highest = $scores ? max($scores) : 0;
                                                ?>
                                                <?php echo e($highest); ?>

                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="pixel-card p-12 text-center bg-white border-dashed">
                    <div class="inline-block p-6 bg-slate-100 rounded-full border-4 border-slate-200 mb-6">
                        <svg class="h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-pixel text-black mb-2">NO SPEAKERS FOUND</h3>
                    <p class="text-base font-sans text-slate-500">Rankings will appear here after matches.</p>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($speakers->count() > 0 && $hasPublishedResults): ?>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="pixel-card p-6 bg-yellow-50 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-16 h-16 bg-yellow-400 border-2 border-black shadow-pixel-sm flex items-center justify-center text-4xl transform -rotate-3">
                            🏆
                        </div>
                        <div>
                            <p class="text-sm font-pixel text-yellow-800 uppercase tracking-widest">Best Speaker</p>
                            <p class="text-2xl font-bold font-sans text-black"><?php echo e($speakers->first()->name ?? 'N/A'); ?></p>
                            <p class="text-sm font-mono text-slate-600"><?php echo e($speakers->first()->total_score ?? 0); ?> pts</p>
                        </div>
                    </div>
                </div>

                <div class="pixel-card p-6 bg-blue-50 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-16 h-16 bg-blue-400 border-2 border-black shadow-pixel-sm flex items-center justify-center text-4xl transform rotate-2">
                            📊
                        </div>
                        <div>
                            <p class="text-sm font-pixel text-blue-800 uppercase tracking-widest">Average Score</p>
                            <p class="text-2xl font-bold font-sans text-black"><?php echo e($speakers->count() > 0 ? number_format($speakers->avg('total_score'), 1) : '0.0'); ?></p>
                            <p class="text-sm font-mono text-slate-600">All Speakers</p>
                        </div>
                    </div>
                </div>

                <div class="pixel-card p-6 bg-green-50 relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-16 h-16 bg-green-400 border-2 border-black shadow-pixel-sm flex items-center justify-center text-4xl transform -rotate-1">
                            🎯
                        </div>
                        <div>
                            <p class="text-sm font-pixel text-green-800 uppercase tracking-widest">Highest Score</p>
                            <p class="text-2xl font-bold font-sans text-black"><?php echo e($speakers->max('total_score') ?? 0); ?></p>
                            <p class="text-sm font-mono text-slate-600">Single Speech</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($speakers->count() > 0 && !$hasPublishedResults): ?>
            <div class="mt-8 pixel-card p-8 bg-slate-50 text-center border-dashed">
                <div class="inline-block p-4 bg-slate-100 rounded-full border-4 border-slate-200 mb-4">
                    🔒
                </div>
                <h3 class="text-xl font-pixel text-slate-600 mb-2">SPEAKER SCORES HIDDEN</h3>
                <p class="text-sm font-sans text-slate-500">Administrator has hidden speaker scores for this tournament.</p>
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/tournaments/speakers.blade.php ENDPATH**/ ?>