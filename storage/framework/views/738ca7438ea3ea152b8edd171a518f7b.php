<?php $__env->startSection('title', 'Results - ' . $tournament->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        
        <div class="mb-8">
            <h1 class="text-5xl font-pixel leading-tight text-england-blue drop-shadow-sm">
                📊 RESULTS: <?php echo e($tournament->name); ?>

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
                    class="pixel-tab pixel-tab-active">
                    📊 RESULTS
                </a>
                <a href="/tournaments/<?php echo e($tournament->id); ?>/speakers"
                    class="pixel-tab text-slate-600 hover:text-black">
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

        
        <div class="mb-6">
            <div class="pixel-card p-6 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-pixel text-black mb-0">FILTER RESULTS BY ROUND</h3>
                    <form method="GET" action="/tournaments/<?php echo e($tournament->id); ?>/results" class="flex items-center gap-4">
                        <select name="round_id" onchange="this.form.submit()"
                            class="pixel-input rounded-none border-2 border-black shadow-pixel-sm text-sm font-pixel py-2 pl-3 pr-10">
                            <option value="">📋 ALL ROUNDS</option>
                            <?php $__currentLoopData = $allRounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($round->id); ?>" <?php echo e($roundId == $round->id ? 'selected' : ''); ?>>
                                    <?php echo e($round->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($roundId): ?>
                            <a href="/tournaments/<?php echo e($tournament->id); ?>/results"
                                class="pixel-btn bg-slate-200 text-black text-sm py-2 hover:bg-slate-300">
                                🗙 CLEAR
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        
        <?php $__empty_1 = true; $__currentLoopData = $tournament->rounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if($round->matches->where('is_completed', true)->count() > 0): ?>
                <div class="mb-12">
                    <h2 class="text-3xl font-pixel text-england-blue mb-6 flex items-center gap-3 border-b-4 border-england-red pb-2 inline-block">
                        📢 <?php echo e($round->name); ?>

                        <?php if($roundId): ?>
                            <span class="px-3 py-1 bg-soft-pink text-england-blue text-sm font-pixel border-2 border-black shadow-pixel-sm transform rotate-3">
                                FILTERED
                            </span>
                        <?php endif; ?>
                    </h2>

                    
                    <div class="pixel-card p-6 mb-8 bg-gradient-to-r from-purple-50 to-indigo-50 border-l-8 border-l-purple-500">
                        <div class="flex items-start gap-4">
                            <span class="text-4xl">💡</span>
                            <div>
                                <p class="text-sm font-pixel text-slate-500 uppercase tracking-widest mb-1">Motion</p>
                                <p class="text-xl font-serif italic text-black leading-relaxed">"<?php echo e($round->motion); ?>"</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <?php $__currentLoopData = $round->matches->where('is_completed', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="pixel-card overflow-hidden bg-white hover:shadow-pixel-lg transition-shadow duration-300">

                                
                                <div class="bg-slate-100 px-6 py-4 border-b-2 border-slate-900 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <span class="text-base font-bold font-sans text-black bg-white px-3 py-1 border-2 border-slate-300 shadow-sm">
                                            📍 <?php echo e($match->room->name ?? 'Room TBA'); ?>

                                        </span>
                                        <span class="text-sm font-pixel text-slate-500 uppercase">
                                            ⚖️ <?php echo e($match->adjudicator->name ?? 'Adjudicator TBA'); ?>

                                        </span>
                                    </div>
                                    <?php if($match->winner): ?>
                                        <span
                                            class="px-4 py-1 bg-green-400 text-black text-sm font-pixel border-2 border-black shadow-pixel-sm transform -rotate-2">
                                            ✅ WINNER: <?php echo e($match->winner->name); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="grid md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x-2 divide-slate-900">

                                    
                                    <div
                                        class="p-6 <?php echo e($match->winner_id == $match->gov_team_id ? 'bg-green-50' : 'bg-white'); ?>">
                                        <div class="flex items-center justify-between mb-6">
                                            <h3 class="font-bold text-xl text-black flex items-center gap-2 font-sans">
                                                🛡️ <?php echo e($match->govTeam->name ?? 'Government'); ?>

                                            </h3>
                                            <span class="px-3 py-1 bg-england-blue text-white text-xs font-pixel border-2 border-black shadow-sm">GOV</span>
                                        </div>

                                        
                                        <div class="space-y-3">
                                            <?php
                                                $govBallots = $match->ballots->where('team_role', 'gov');
                                                $govTotal = $govBallots->sum('score');
                                            ?>
                                            <?php if($round->results_published): ?>
                                                <?php $__currentLoopData = $govBallots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ballot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex justify-between items-center p-3 bg-white border-2 border-slate-200 shadow-sm">
                                                        <span class="text-sm font-bold text-black font-sans">
                                                            <?php echo e($ballot->speaker->name ?? 'Speaker'); ?>

                                                        </span>
                                                        <span class="text-lg font-pixel text-england-blue">
                                                            <?php echo e($ballot->score); ?> pts
                                                        </span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <div class="mt-4 pt-4 border-t-2 border-slate-900 border-dashed flex justify-between items-center">
                                                    <span class="text-sm font-pixel text-slate-500 uppercase">Total Score</span>
                                                    <span class="text-2xl font-pixel text-black"><?php echo e($govTotal); ?></span>
                                                </div>
                                            <?php else: ?>
                                                <div class="p-6 text-center bg-slate-50 border-2 border-slate-200 border-dashed">
                                                    <p class="text-sm font-pixel text-slate-400">🔒 Speaker scores hidden</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    
                                    <div
                                        class="p-6 <?php echo e($match->winner_id == $match->opp_team_id ? 'bg-green-50' : 'bg-white'); ?>">
                                        <div class="flex items-center justify-between mb-6">
                                            <h3 class="font-bold text-xl text-black flex items-center gap-2 font-sans">
                                                🔥 <?php echo e($match->oppTeam->name ?? 'Opposition'); ?>

                                            </h3>
                                            <span class="px-3 py-1 bg-england-red text-white text-xs font-pixel border-2 border-black shadow-sm">OPP</span>
                                        </div>

                                        
                                        <div class="space-y-3">
                                            <?php
                                                $oppBallots = $match->ballots->where('team_role', 'opp');
                                                $oppTotal = $oppBallots->sum('score');
                                            ?>
                                            <?php if($round->results_published): ?>
                                                <?php $__currentLoopData = $oppBallots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ballot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex justify-between items-center p-3 bg-white border-2 border-slate-200 shadow-sm">
                                                        <span class="text-sm font-bold text-black font-sans">
                                                            <?php echo e($ballot->speaker->name ?? 'Speaker'); ?>

                                                        </span>
                                                        <span class="text-lg font-pixel text-england-red">
                                                            <?php echo e($ballot->score); ?> pts
                                                        </span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <div class="mt-4 pt-4 border-t-2 border-slate-900 border-dashed flex justify-between items-center">
                                                    <span class="text-sm font-pixel text-slate-500 uppercase">Total Score</span>
                                                    <span class="text-2xl font-pixel text-black"><?php echo e($oppTotal); ?></span>
                                                </div>
                                            <?php else: ?>
                                                <div class="p-6 text-center bg-slate-50 border-2 border-slate-200 border-dashed">
                                                    <p class="text-sm font-pixel text-slate-400">🔒 Speaker scores hidden</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="bg-slate-50 px-6 py-4 border-t-2 border-slate-900">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <h4 class="text-sm font-pixel text-black mb-1 uppercase">
                                                ⭐ Rate Adjudicator
                                            </h4>
                                            <p class="text-xs text-slate-500 font-sans">Help improve judging quality.</p>
                                        </div>

                                        <button
                                            onclick="document.getElementById('review-modal-<?php echo e($match->id); ?>').classList.remove('hidden')"
                                            class="pixel-btn bg-white text-black text-xs py-2 hover:bg-yellow-50">
                                            LEAVE REVIEW
                                        </button>
                                    </div>
                                </div>
                            </div>

                            
                            <div id="review-modal-<?php echo e($match->id); ?>"
                                class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                                <div class="pixel-card w-full max-w-md bg-white p-6 relative">
                                    <button
                                        onclick="document.getElementById('review-modal-<?php echo e($match->id); ?>').classList.add('hidden')"
                                        class="absolute top-4 right-4 text-black hover:text-england-red">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    <h3 class="text-2xl font-pixel text-black mb-6 border-b-4 border-soft-pink inline-block">RATE ADJUDICATOR</h3>

                                    <form action="<?php echo e(route('public.adjudicator-reviews.store', $match)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="adjudicator_id" value="<?php echo e($match->adjudicator->id ?? ''); ?>">
                                        <div class="space-y-6">
                                            <div>
                                                <label class="block text-sm font-pixel text-slate-500 uppercase mb-2">Adjudicator</label>
                                                <p class="text-lg font-bold font-sans text-black bg-slate-100 p-2 border-2 border-slate-200"><?php echo e($match->adjudicator->name ?? 'N/A'); ?></p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-pixel text-slate-500 uppercase mb-2">Rating</label>
                                                <div class="flex gap-2 justify-center">
                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                        <label class="cursor-pointer group relative">
                                                            <input type="radio" name="rating" value="<?php echo e($i); ?>" required
                                                                class="sr-only peer">
                                                            <span class="text-5xl transition-all duration-200 
                                                                peer-checked:scale-110 
                                                                peer-checked:filter-none
                                                                group-hover:scale-110 
                                                                group-hover:filter-none
                                                                filter grayscale">⭐</span>
                                                        </label>
                                                    <?php endfor; ?>
                                                </div>
                                                <p class="text-xs text-center text-slate-400 mt-2 font-sans">Click on stars to rate (1-5)</p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-pixel text-slate-500 uppercase mb-2">Comment</label>
                                                <textarea name="comment" rows="3"
                                                    class="pixel-input w-full p-3"
                                                    placeholder="Share your feedback..."></textarea>
                                            </div>

                                            <div class="flex gap-4 pt-4">
                                                <button type="submit"
                                                    class="pixel-btn pixel-btn-primary flex-1">
                                                    SUBMIT
                                                </button>
                                                <button type="button"
                                                    onclick="document.getElementById('review-modal-<?php echo e($match->id); ?>').classList.add('hidden')"
                                                    class="pixel-btn bg-slate-200 hover:bg-slate-300 text-black">
                                                    CANCEL
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="pixel-card p-12 text-center bg-white">
                <div class="inline-block p-6 bg-slate-100 rounded-full border-4 border-slate-200 mb-6">
                    <svg class="h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-pixel text-black mb-2">
                    <?php if($roundId): ?>
                        NO MATCHES FOUND
                    <?php else: ?>
                        NO RESULTS YET
                    <?php endif; ?>
                </h3>
                <p class="text-base font-sans text-slate-500">
                    <?php if($roundId): ?>
                        This round has no completed matches yet.
                    <?php else: ?>
                        Completed matches will appear here.
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views/tournaments/results.blade.php ENDPATH**/ ?>