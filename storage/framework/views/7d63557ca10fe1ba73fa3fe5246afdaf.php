<?php $__env->startSection('title', 'Matches - ' . $tournament->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                ⚔️ MATCHES: <?php echo e($tournament->name); ?>

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
                <a href="/tournaments/<?php echo e($tournament->id); ?>/matches" class="pixel-tab pixel-tab-active">
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
                <a href="/tournaments/<?php echo e($tournament->id); ?>/participants" class="pixel-tab text-slate-600 hover:text-black">
                    👥 PARTICIPANTS
                </a>
            </nav>
        </div>

        <div class="space-y-6"
            x-data="{ selectedRound: '<?php echo e($tournament->rounds->sortBy('created_at')->first()->id ?? ''); ?>' }">

            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pixel-card p-4 bg-soft-pink/20">
                <div>
                    <h3 class="text-xl font-pixel text-england-blue">MATCH LIST</h3>
                    <p class="text-sm font-sans text-slate-600">Select a round to view the draw.</p>
                </div>

                <div class="w-full sm:w-64">
                    <?php if($tournament->rounds->count() > 0): ?>
                        <select x-model="selectedRound" class="pixel-input block w-full bg-white text-lg font-pixel">
                            <?php $__currentLoopData = $tournament->rounds->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($round->id); ?>">
                                    <?php echo e($round->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php else: ?>
                        <span class="text-sm font-pixel text-england-red bg-white px-2 py-1 border-2 border-england-red">NO
                            ROUNDS YET</span>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="pixel-card overflow-hidden bg-white">
                <?php if($tournament->rounds->count() > 0): ?>
                    <?php $__currentLoopData = $tournament->rounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div x-show="selectedRound == '<?php echo e($round->id); ?>'" style="display: none;">

                            
                            <div class="px-6 py-4 border-b-4 border-slate-200 bg-slate-50">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-pixel text-2xl text-england-blue"><?php echo e($round->name); ?></h4>
                                    <span
                                        class="px-3 py-1 text-sm font-pixel border-2 border-black shadow-pixel-sm <?php echo e($round->is_published ? 'bg-green-400 text-black' : 'bg-yellow-300 text-black'); ?>">
                                        <?php echo e($round->is_published ? 'PUBLISHED' : 'DRAFT'); ?>

                                    </span>
                                </div>
                                <?php if($round->is_motion_published && $round->motion): ?>
                                    <div class="mt-4 p-3 bg-white border-2 border-slate-300 shadow-sm">
                                        <span class="font-pixel text-england-red uppercase mr-2">Motion:</span>
                                        <span class="font-serif italic text-lg text-black">"<?php echo e($round->motion); ?>"</span>
                                    </div>
                                <?php elseif(!$round->is_motion_published): ?>
                                    <div class="mt-4 p-3 bg-yellow-50 border-2 border-yellow-300 shadow-sm">
                                        <span class="font-pixel text-yellow-700">Motion belum dipublikasikan</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y-2 divide-slate-200">
                                    <thead class="bg-england-blue text-white">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                                Venue</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                                Proposition (Gov)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                                VS</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-lg font-pixel tracking-wider border-r-2 border-white/20">
                                                Opposition (Opp)</th>
                                            <th scope="col" class="px-6 py-3 text-center text-lg font-pixel tracking-wider">
                                                Adjudicators</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y-2 divide-slate-100">
                                        <?php $__empty_1 = true; $__currentLoopData = $round->matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr class="hover:bg-soft-pink/10 transition-colors">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-base font-bold font-sans text-black border-r border-slate-100">
                                                    📍 <?php echo e($match->room->name ?? 'TBA'); ?>

                                                </td>

                                                
                                                <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                                    <div class="text-base font-bold text-black font-sans">
                                                        <?php echo e($match->govTeam->emoji ?? '🛡️'); ?>

                                                        <?php echo e($match->govTeam->name ?? 'N/A'); ?>

                                                    </div>
                                                    <div class="text-xs text-slate-500 font-mono">
                                                        <?php echo e($match->govTeam->institution ?? ''); ?>

                                                    </div>
                                                </td>

                                                
                                                <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                                    <?php if($match->is_completed): ?>
                                                        <div class="flex flex-col items-center gap-2">
                                                            <span
                                                                class="inline-flex items-center justify-center px-3 py-1 text-sm font-pixel text-white bg-green-600 border-2 border-black shadow-pixel-sm">
                                                                ✓ BALLOT FILLED
                                                            </span>
                                                            <?php if($round->results_published): ?>
                                                                
                                                                <?php
                                                                    $govScore = $match->ballots->where('team_role', 'gov')->sum('score') + ($match->gov_reply_score ?? 0);
                                                                    $oppScore = $match->ballots->where('team_role', 'opp')->sum('score') + ($match->opp_reply_score ?? 0);
                                                                ?>
                                                                <div class="text-lg font-pixel text-black">
                                                                    <?php echo e($govScore); ?> - <?php echo e($oppScore); ?>

                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <span
                                                            class="inline-flex items-center justify-center px-2 py-1 text-xl font-pixel text-white bg-england-red border-2 border-black shadow-pixel-sm transform rotate-12">
                                                            VS
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                
                                                <td class="px-6 py-4 whitespace-nowrap text-center border-r border-slate-100">
                                                    <div class="text-base font-bold text-black font-sans">
                                                        <?php echo e($match->oppTeam->emoji ?? '🔥'); ?>

                                                        <?php echo e($match->oppTeam->name ?? 'N/A'); ?>

                                                    </div>
                                                    <div class="text-xs text-slate-500 font-mono">
                                                        <?php echo e($match->oppTeam->institution ?? ''); ?>

                                                    </div>
                                                </td>

                                                
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex flex-col items-center gap-1">
                                                        <?php if($match->adjudicator): ?>
                                                            <span
                                                                class="inline-flex items-center px-3 py-1 border-2 border-blue-800 text-xs font-pixel bg-blue-100 text-blue-900 shadow-sm">
                                                                ⚖️ <?php echo e($match->adjudicator->name); ?>

                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-xs font-pixel text-slate-400">NO ADJUDICATOR</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5" class="px-6 py-10 text-center text-lg font-pixel text-slate-500">
                                                    No pairings available for this round.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="p-10 text-center">
                        <div class="inline-block p-4 bg-slate-100 rounded-full mb-4 border-4 border-slate-200">
                            <svg class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-xl font-pixel text-black">NO DATA</h3>
                        <p class="mt-1 text-sm font-sans text-slate-500">Match schedule is not yet available.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/tournaments/matches.blade.php ENDPATH**/ ?>