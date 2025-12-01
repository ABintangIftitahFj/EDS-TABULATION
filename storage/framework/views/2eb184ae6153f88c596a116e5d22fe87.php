<?php $__env->startSection('title', $tournament->name); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if(session('success')): ?>
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border-l-4 border-green-500 shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium"><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Admin Home Button -->
    <div class="mb-4">
        <a href="<?php echo e(route('admin.dashboard')); ?>"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-300 rounded-md hover:bg-indigo-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            🏠 Admin Home
        </a>
    </div>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-black"><?php echo e($tournament->name); ?></h1>
                <p class="text-black mt-1"><?php echo e($tournament->format); ?> • <?php echo e($tournament->location); ?></p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo e(route('admin.tournaments.edit', $tournament)); ?>"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-black hover:bg-slate-50">
                    Edit Tournament
                </a>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                    <?php echo e($tournament->status === 'ongoing' ? 'bg-green-100 text-green-800' : ($tournament->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-black')); ?>">
                    <?php echo e(ucfirst($tournament->status)); ?>

                </span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <a href="<?php echo e(route('admin.teams.index', ['tournament_id' => $tournament->id])); ?>"
            class="bg-blue-600 rounded-xl shadow-lg p-6 text-black border-2 border-blue-700 hover:bg-blue-700 hover:scale-105 transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-50 text-sm font-medium uppercase tracking-wide">Teams</p>
                    <p class="text-4xl font-bold mt-2"><?php echo e($tournament->teams->count()); ?></p>
                </div>
                <div class="bg-blue-700 rounded-lg p-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('admin.adjudicators.index', ['tournament_id' => $tournament->id])); ?>"
            class="bg-purple-600 rounded-xl shadow-lg p-6 text-black border-2 border-purple-700 hover:bg-purple-700 hover:scale-105 transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-50 text-sm font-medium uppercase tracking-wide">Adjudicators</p>
                    <p class="text-4xl font-bold mt-2"><?php echo e($tournament->adjudicators->count()); ?></p>
                </div>
                <div class="bg-purple-700 rounded-lg p-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('admin.rounds.index', ['tournament_id' => $tournament->id])); ?>"
            class="bg-green-600 rounded-xl shadow-lg p-6 text-black border-2 border-green-700 hover:bg-green-700 hover:scale-105 transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-50 text-sm font-medium uppercase tracking-wide">Rounds</p>
                    <p class="text-4xl font-bold mt-2"><?php echo e($tournament->rounds->count()); ?></p>
                </div>
                <div class="bg-green-700 rounded-lg p-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('admin.speakers.index', ['tournament_id' => $tournament->id])); ?>"
            class="bg-orange-600 rounded-xl shadow-lg p-6 text-black border-2 border-orange-700 hover:bg-orange-700 hover:scale-105 transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-50 text-sm font-medium uppercase tracking-wide">Speakers</p>
                    <p class="text-4xl font-bold mt-2"><?php echo e($tournament->teams->sum(fn($t) => $t->speakers->count())); ?></p>
                </div>
                <div class="bg-orange-700 rounded-lg p-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="<?php echo e(route('admin.tournaments.import', $tournament)); ?>"
            class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Import Data</h3>
                    <p class="text-sm text-black">Upload CSV files</p>
                </div>
            </div>
        </a>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-green-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Add Round</h3>
                    <p class="text-sm text-black">Create new round</p>
                </div>
            </div>
            <div class="flex gap-2">
                <form action="<?php echo e(route('admin.rounds.auto-store')); ?>" method="POST" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="tournament_id" value="<?php echo e($tournament->id); ?>">
                    <button type="submit"
                        class="w-full px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                        Auto Add
                    </button>
                </form>
                <a href="<?php echo e(route('admin.rounds.create')); ?>?tournament_id=<?php echo e($tournament->id); ?>"
                    class="flex-1 px-3 py-2 text-sm font-medium text-center text-green-700 bg-green-100 border border-green-300 rounded-lg hover:bg-green-200 focus:ring-4 focus:outline-none focus:ring-green-300">
                    Manual
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-purple-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Create Match</h3>
                    <p class="text-sm text-black">Generate pairings</p>
                </div>
            </div>
            <?php if($tournament->rounds->count() > 0): ?>
                <div class="mb-3">
                    <label for="match_round_select" class="block text-xs font-medium text-gray-700 mb-1">Select Round:</label>
                    <select id="match_round_select"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <?php $__currentLoopData = $tournament->rounds->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($round->id); ?>" <?php echo e($loop->first ? 'selected' : ''); ?>>
                                <?php echo e($round->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="autoGenerateMatch()"
                        class="flex-1 px-3 py-2 text-sm font-medium text-center text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-300">
                        Auto Draw
                    </button>
                    <a href="<?php echo e(route('admin.matches.create')); ?>?tournament_id=<?php echo e($tournament->id); ?>"
                        class="flex-1 px-3 py-2 text-sm font-medium text-center text-purple-700 bg-purple-100 border border-purple-300 rounded-lg hover:bg-purple-200 focus:ring-4 focus:outline-none focus:ring-purple-300">
                        Manual
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-3">
                    <p class="text-sm text-gray-500 mb-2">No rounds available</p>
                    <p class="text-xs text-gray-400">Please create a round first</p>
                </div>
            <?php endif; ?>
        </div>

        <a href="<?php echo e(route('admin.teams.create')); ?>?tournament_id=<?php echo e($tournament->id); ?>"
            class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Add Team</h3>
                    <p class="text-sm text-black">Manually add team</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('admin.adjudicators.create')); ?>?tournament_id=<?php echo e($tournament->id); ?>"
            class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-orange-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Add Adjudicator</h3>
                    <p class="text-sm text-black">Manually add adjudicator</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('admin.rooms.create')); ?>?tournament_id=<?php echo e($tournament->id); ?>"
            class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Add Room</h3>
                    <p class="text-sm text-black">Manually add room</p>
                </div>
            </div>
        </a>

        <!-- Add Motion Card -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-yellow-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Add Motion</h3>
                    <p class="text-sm text-black">Set motion for round</p>
                </div>
            </div>
            <?php if($tournament->rounds->count() > 0): ?>
                <div class="mb-3">
                    <label for="motion_round_select" class="block text-xs font-medium text-gray-700 mb-1">Select Round:</label>
                    <select id="motion_round_select" 
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        <?php $__currentLoopData = $tournament->rounds->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($round->id); ?>" data-motion="<?php echo e($round->motion ?? ''); ?>">
                                <?php echo e($round->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="button" onclick="openMotionModal()"
                    class="w-full px-3 py-2 text-sm font-medium text-center text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300">
                    💡 Add/Edit Motion
                </button>
            <?php else: ?>
                <div class="text-center py-3">
                    <p class="text-sm text-gray-500 mb-2">No rounds available</p>
                    <p class="text-xs text-gray-400">Please create a round first</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Input Score Card -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-teal-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-black">Quick Input Score</h3>
                    <p class="text-sm text-black">Enter ballot quickly</p>
                </div>
            </div>
            <?php
                $allMatches = $tournament->rounds->flatMap->matches;
            ?>
            <?php if($allMatches->count() > 0): ?>
                <div class="mb-3">
                    <label for="quick_score_match_select" class="block text-xs font-medium text-gray-700 mb-1">Select Match:</label>
                    <select id="quick_score_match_select" 
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <?php $__currentLoopData = $tournament->rounds->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $round->matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($match->id); ?>">
                                    <?php echo e($round->name); ?> - <?php echo e($match->govTeam->name ?? 'TBA'); ?> vs <?php echo e($match->oppTeam->name ?? 'TBA'); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="button" onclick="openQuickScoreModal()"
                    class="w-full px-3 py-2 text-sm font-medium text-center text-white bg-teal-600 rounded-lg hover:bg-teal-700 focus:ring-4 focus:outline-none focus:ring-teal-300">
                    📝 Input Score Now
                </button>
            <?php else: ?>
                <div class="text-center py-3">
                    <p class="text-sm text-gray-500 mb-2">No matches available</p>
                    <p class="text-xs text-gray-400">Please create matches first</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabs Content -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200">
        <div class="border-b border-slate-200">
            <nav class="flex -mb-px">
                <button class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-indigo-600 text-indigo-600"
                    data-tab="teams">
                    Teams
                </button>
                <button class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-black"
                    data-tab="adjudicators">
                    Adjudicators
                </button>
                <button class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-black"
                    data-tab="rounds">
                    Rounds
                </button>
                <button class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-black"
                    data-tab="draw">
                    Draw
                </button>
            </nav>
        </div>

        <div class="p-4 md:p-6">
            <!-- Teams Tab -->
            <div id="teams-tab" class="tab-content">
                <!-- Mobile View: Cards -->
                <div class="md:hidden space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $tournament->teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <div class="flex items-start justify-between mb-2">
                                <div class="font-semibold text-black text-lg"><?php echo e($team->name); ?></div>
                            </div>
                            <div class="text-sm text-gray-600 mb-2">
                                <span class="font-medium">Institution:</span> <?php echo e($team->institution ?? '-'); ?>

                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Speakers:</span>
                                <?php echo e($team->speakers->pluck('name')->join(', ') ?: '-'); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8 text-gray-500">No teams yet</div>
                    <?php endif; ?>
                </div>

                <!-- Desktop View: Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Team</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Institution</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Speakers</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <?php $__empty_1 = true; $__currentLoopData = $tournament->teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-black"><?php echo e($team->name); ?></td>
                                    <td class="px-4 py-3 text-sm text-black"><?php echo e($team->institution); ?></td>
                                    <td class="px-4 py-3 text-sm text-black">
                                        <?php echo e($team->speakers->pluck('name')->join(', ')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-black">No teams yet</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Adjudicators Tab -->
            <div id="adjudicators-tab" class="tab-content hidden">
                <!-- Mobile View: Cards -->
                <div class="md:hidden space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $tournament->adjudicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <div class="flex items-start justify-between mb-2">
                                <div class="font-semibold text-black text-lg"><?php echo e($adj->name); ?></div>
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                    <?php echo e($adj->rating ?? 'N/A'); ?>

                                </span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Institution:</span> <?php echo e($adj->institution ?? '-'); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8 text-gray-500">No adjudicators yet</div>
                    <?php endif; ?>
                </div>

                <!-- Desktop View: Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Institution</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <?php $__empty_1 = true; $__currentLoopData = $tournament->adjudicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-black"><?php echo e($adj->name); ?></td>
                                    <td class="px-4 py-3 text-sm text-black"><?php echo e($adj->institution); ?></td>
                                    <td class="px-4 py-3 text-sm text-black"><?php echo e($adj->rating ?? 'N/A'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-black">No adjudicators yet</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rounds Tab -->
            <div id="rounds-tab" class="tab-content hidden">
                <!-- Mobile View: Cards -->
                <div class="md:hidden space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $tournament->rounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="font-semibold text-black text-lg"><?php echo e($round->name); ?></div>
                            </div>
                            <div class="text-sm text-gray-600 mb-3">
                                <span class="font-medium">Motion:</span> <?php echo e($round->motion ?? 'TBA'); ?>

                            </div>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($round->is_motion_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e($round->is_motion_published ? '👁️ Motion Public' : '🔒 Motion Hidden'); ?>

                                </span>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($round->is_draw_published ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800'); ?>">
                                    <?php echo e($round->is_draw_published ? '🔓 Draw Public' : '🔐 Draw Locked'); ?>

                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <form action="<?php echo e(route('admin.rounds.toggle-motion', $round)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="w-full px-3 py-2 rounded text-xs font-medium transition <?php echo e($round->is_motion_published ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-500 hover:bg-gray-600'); ?> text-white">
                                        <?php echo e($round->is_motion_published ? '👁️' : '🔒'); ?> Motion
                                    </button>
                                </form>
                                <form action="<?php echo e(route('admin.rounds.toggle-draw', $round)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="w-full px-3 py-2 rounded text-xs font-medium transition <?php echo e($round->is_draw_published ? 'bg-blue-500 hover:bg-blue-600' : 'bg-orange-500 hover:bg-orange-600'); ?> text-white">
                                        <?php echo e($round->is_draw_published ? '🔓' : '🔐'); ?> Draw
                                    </button>
                                </form>
                                <form action="<?php echo e(route('admin.matches.auto-generate')); ?>" method="POST" class="inline"
                                    onsubmit="return confirm('Auto-generate draw for <?php echo e($round->name); ?>?');">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="round_id" value="<?php echo e($round->id); ?>">
                                    <button type="submit"
                                        class="w-full px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition text-xs font-medium">
                                        ⚡ Auto Draw
                                    </button>
                                </form>
                                <a href="<?php echo e(route('admin.matches.create')); ?>?tournament_id=<?php echo e($tournament->id); ?>&round_id=<?php echo e($round->id); ?>"
                                    class="w-full px-3 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition text-xs font-medium text-center">
                                    ➕ Manual
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8 text-gray-500">No rounds yet</div>
                    <?php endif; ?>
                </div>

                <!-- Desktop View: Table with Horizontal Scroll -->
                <div class="hidden md:block">
                    <!-- Swipe Indicator -->
                    <div class="mb-2 text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                        <span>👉 Geser ke kanan untuk melihat tombol aksi</span>
                    </div>

                    <!-- Scrollable Container with Shadow Indicators -->
                    <div class="overflow-x-auto border border-slate-200 rounded-lg shadow-sm" style="max-width: 100%;">
                        <table class="w-full divide-y divide-slate-200" style="min-width: 900px;">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-black uppercase sticky left-0 bg-slate-50 z-10 border-r border-slate-200">
                                        Round</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase"
                                        style="min-width: 200px;">Motion</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-black uppercase"
                                        style="min-width: 150px;">Status</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-black uppercase whitespace-nowrap"
                                        style="min-width: 400px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                <?php $__empty_1 = true; $__currentLoopData = $tournament->rounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-slate-50">
                                        <td
                                            class="px-4 py-3 text-sm font-medium text-black sticky left-0 bg-white z-10 border-r border-slate-200">
                                            <?php echo e($round->name); ?>

                                        </td>
                                        <td class="px-4 py-3 text-sm text-black"><?php echo e($round->motion ?? 'TBA'); ?></td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex flex-col gap-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($round->is_motion_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                                    <?php echo e($round->is_motion_published ? '👁️ Motion Public' : '🔒 Motion Hidden'); ?>

                                                </span>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($round->is_draw_published ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800'); ?>">
                                                    <?php echo e($round->is_draw_published ? '🔓 Draw Public' : '🔐 Draw Locked'); ?>

                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right">
                                            <div class="flex justify-end gap-2 flex-nowrap whitespace-nowrap">
                                                <form action="<?php echo e(route('admin.rounds.toggle-motion', $round)); ?>" method="POST"
                                                    class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit"
                                                        class="px-2 py-1 rounded text-xs font-medium transition <?php echo e($round->is_motion_published ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-500 hover:bg-gray-600'); ?> text-white"
                                                        title="<?php echo e($round->is_motion_published ? 'Hide Motion' : 'Publish Motion'); ?>">
                                                        <?php echo e($round->is_motion_published ? '👁️' : '🔒'); ?> Motion
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('admin.rounds.toggle-draw', $round)); ?>" method="POST"
                                                    class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit"
                                                        class="px-2 py-1 rounded text-xs font-medium transition <?php echo e($round->is_draw_published ? 'bg-blue-500 hover:bg-blue-600' : 'bg-orange-500 hover:bg-orange-600'); ?> text-white"
                                                        title="<?php echo e($round->is_draw_published ? 'Lock Draw' : 'Unlock Draw'); ?>">
                                                        <?php echo e($round->is_draw_published ? '🔓' : '🔐'); ?> Draw
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('admin.matches.auto-generate')); ?>" method="POST"
                                                    onsubmit="return confirm('Auto-generate draw for <?php echo e($round->name); ?>?');">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="round_id" value="<?php echo e($round->id); ?>">
                                                    <button type="submit"
                                                        class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition text-xs font-medium">
                                                        Auto Draw
                                                    </button>
                                                </form>
                                                <a href="<?php echo e(route('admin.matches.create')); ?>?tournament_id=<?php echo e($tournament->id); ?>&round_id=<?php echo e($round->id); ?>"
                                                    class="px-2 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition text-xs font-medium">
                                                    Manual
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-black">No rounds yet</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Draw Tab -->
            <div id="draw-tab" class="tab-content hidden">
                <div class="space-y-6">
                    <?php $__empty_1 = true; $__currentLoopData = $tournament->rounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <h3 class="text-lg font-bold text-black mb-4"><?php echo e($round->name); ?></h3>

                            <?php if($round->matches->count() > 0): ?>
                                <div class="space-y-3">
                                    <?php $__currentLoopData = $round->matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
                                            <!-- Match Info -->
                                            <div class="mb-3">
                                                <div class="text-xs font-medium text-gray-500 mb-2">
                                                    📍 <?php echo e($match->room->name ?? 'Room TBA'); ?> • 👨‍⚖️
                                                    <?php echo e($match->adjudicator->name ?? 'Adj TBA'); ?>

                                                </div>

                                                <!-- Teams Display -->
                                                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4">
                                                    <div class="flex-1 text-center sm:text-right">
                                                        <span
                                                            class="font-bold text-blue-700 text-sm sm:text-base"><?php echo e($match->govTeam->name ?? 'TBA'); ?></span>
                                                        <span class="block text-xs text-gray-500">Gov</span>
                                                    </div>
                                                    <div class="font-bold text-gray-400 text-sm">VS</div>
                                                    <div class="flex-1 text-center sm:text-left">
                                                        <span
                                                            class="font-bold text-red-700 text-sm sm:text-base"><?php echo e($match->oppTeam->name ?? 'TBA'); ?></span>
                                                        <span class="block text-xs text-gray-500">Opp</span>
                                                    </div>
                                                </div>

                                                <?php if($match->cgTeam || $match->coTeam): ?>
                                                    <div
                                                        class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 mt-2 pt-2 border-t border-gray-100">
                                                        <?php if($match->cgTeam): ?>
                                                            <div class="flex-1 text-center sm:text-right">
                                                                <span
                                                                    class="font-bold text-green-700 text-sm"><?php echo e($match->cgTeam->name ?? 'TBA'); ?></span>
                                                                <span class="block text-xs text-gray-500">CG</span>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if($match->coTeam): ?>
                                                            <div class="flex-1 text-center sm:text-left">
                                                                <span
                                                                    class="font-bold text-orange-700 text-sm"><?php echo e($match->coTeam->name ?? 'TBA'); ?></span>
                                                                <span class="block text-xs text-gray-500">CO</span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Action Buttons - Mobile Friendly -->
                                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-3 border-t border-gray-100">
                                                <!-- Input/Edit Score Button -->
                                                <div class="relative">
                                                    <button onclick="openScoreModal('<?php echo e(route('admin.ballots.create', $match)); ?>')"
                                                        class="w-full px-3 py-2.5 <?php echo e($match->ballots()->exists() ? 'bg-amber-600 hover:bg-amber-700' : 'bg-indigo-600 hover:bg-indigo-700'); ?> text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                                                        <?php echo e($match->ballots()->exists() ? '✏️ Edit Score' : '📝 Input Score'); ?>

                                                    </button>
                                                    <?php if($match->ballots()->exists()): ?>
                                                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                                            <span
                                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Edit Match Button -->
                                                <a href="<?php echo e(route('admin.matches.edit', $match)); ?>"
                                                    class="w-full px-3 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors text-center flex items-center justify-center gap-2">
                                                    ⚙️ Edit Match
                                                </a>
                                                
                                                <!-- Delete Score Button (only if score exists) -->
                                                <?php if($match->ballots()->exists()): ?>
                                                    <form action="<?php echo e(route('admin.ballots.destroy', $match->ballots()->first())); ?>" method="POST" class="w-full"
                                                        onsubmit="return confirm('Delete score for this match?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit"
                                                            class="w-full px-3 py-2.5 bg-orange-100 text-orange-700 text-sm font-medium rounded-lg hover:bg-orange-200 transition-colors flex items-center justify-center gap-2">
                                                            🗑️ Delete Score
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <div class="w-full px-3 py-2.5 bg-gray-100 text-gray-400 text-sm font-medium rounded-lg text-center flex items-center justify-center gap-2 cursor-not-allowed">
                                                        🚫 No Score
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <!-- Delete Match Button -->
                                                <form action="<?php echo e(route('admin.matches.destroy', $match)); ?>\" method="POST" class="w-full"
                                                    onsubmit="return confirm('Delete this match?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                        class="w-full px-3 py-2.5 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center gap-2">
                                                        ❌ Delete Match
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 text-sm italic">No matches generated for this round yet.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center text-gray-500 py-8">No rounds found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Score Modal -->
    <div id="scoreModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeScoreModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[80vh] w-full flex flex-col overflow-hidden">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Enter Ballot</h3>
                        <button onclick="closeScoreModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <iframe id="scoreFrame" src="" class="w-full h-[50vh] sm:h-[60vh] md:h-[70vh] border-0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Motion Modal -->
    <div id="motionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeMotionModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full w-full">
                <div class="bg-white px-6 pt-5 pb-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Add/Edit Motion</h3>
                        <button onclick="closeMotionModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form id="motionForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="motion_round_id" name="round_id">
                        <div class="mb-4">
                            <label for="motion_text" class="block text-sm font-medium text-gray-700 mb-2">Motion Text</label>
                            <textarea id="motion_text" name="motion" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Enter the motion for this round..." required></textarea>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeMotionModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700">
                                Save Motion
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.dataset.tab;

                // Update buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('border-indigo-600', 'text-indigo-600', 'active');
                    btn.classList.add('border-transparent', 'text-black');
                });
                button.classList.add('border-indigo-600', 'text-indigo-600', 'active');
                button.classList.remove('border-transparent', 'text-black');

                // Update content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(`${tabName}-tab`).classList.remove('hidden');
            });
        });

        // Handle URL hash to auto-open specific tab on page load
        function openTabFromHash() {
            const hash = window.location.hash;
            if (hash) {
                const tabName = hash.replace('#', '').replace('-tab', '');
                const tabButton = document.querySelector(`[data-tab="${tabName}"]`);
                
                if (tabButton) {
                    // Trigger click on the tab button
                    tabButton.click();
                    
                    // Scroll to tabs section
                    setTimeout(() => {
                        const tabsSection = document.querySelector('.tab-content');
                        if (tabsSection) {
                            tabsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }, 100);
                }
            }
        }

        // Run on page load
        openTabFromHash();

        // Also run when hash changes (browser back/forward)
        window.addEventListener('hashchange', openTabFromHash);

        function openScoreModal(url) {
            document.getElementById('scoreFrame').src = url;
            document.getElementById('scoreModal').classList.remove('hidden');
        }

        function closeScoreModal() {
            const modal = document.getElementById('scoreModal');
            const iframe = document.getElementById('scoreFrame');
            modal.classList.add('hidden');
            // Clear iframe src completely to fix reload issue
            iframe.src = 'about:blank';
            setTimeout(() => {
                iframe.src = '';
            }, 100);
        }

        // Motion Modal Functions
        function openMotionModal() {
            const roundSelect = document.getElementById('motion_round_select');
            const roundId = roundSelect.value;
            const selectedOption = roundSelect.options[roundSelect.selectedIndex];
            const currentMotion = selectedOption.dataset.motion;

            document.getElementById('motion_round_id').value = roundId;
            document.getElementById('motion_text').value = currentMotion || '';
            document.getElementById('motionModal').classList.remove('hidden');
        }

        function closeMotionModal() {
            document.getElementById('motionModal').classList.add('hidden');
            document.getElementById('motionForm').reset();
        }

        // Quick Score Modal Function
        function openQuickScoreModal() {
            const matchSelect = document.getElementById('quick_score_match_select');
            const matchId = matchSelect.value;
            const url = `/admin/ballots/${matchId}/create`;
            
            // Use the existing openScoreModal function but ensure it's fresh
            document.getElementById('scoreFrame').src = '';
            setTimeout(() => {
                openScoreModal(url);
            }, 100);
        }

        // Motion Form Submission
        document.getElementById('motionForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const roundId = document.getElementById('motion_round_id').value;
            const motion = document.getElementById('motion_text').value;
            const formData = new FormData();
            formData.append('motion', motion);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            formData.append('_method', 'PATCH');

            try {
                const response = await fetch(`/admin/rounds/${roundId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    await Swal.fire({
                        title: 'Success! 🎉',
                        text: 'Motion has been saved!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#D97706',
                        timer: 2000
                    });

                    closeMotionModal();
                    window.location.reload();
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to save motion.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while saving the motion.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });

        // AJAX Handler untuk Toggle Motion
        document.querySelectorAll('form[action*="toggle-motion"]').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

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

                    if (data.success) {
                        // Show SweetAlert with cute animation
                        Swal.fire({
                            title: data.round_name,
                            html: `<div style="font-size: 1.1em;">${data.message}</div>`,
                            icon: 'success',
                            confirmButtonText: 'OK! 👍',
                            confirmButtonColor: '#4F46E5',
                            showClass: {
                                popup: 'animate__animated animate__bounceIn'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut'
                            }
                        }).then(() => {
                            // Reload page to update button states
                            window.location.reload();
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses permintaan.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // AJAX Handler untuk Toggle Draw
        document.querySelectorAll('form[action*="toggle-draw"]').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

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

                    if (data.success) {
                        // Show SweetAlert with cute animation
                        Swal.fire({
                            title: data.round_name,
                            html: `<div style="font-size: 1.1em;">${data.message}</div>`,
                            icon: 'success',
                            confirmButtonText: 'Mantap! 🚀',
                            confirmButtonColor: '#3B82F6',
                            showClass: {
                                popup: 'animate__animated animate__bounceIn'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut'
                            }
                        }).then(() => {
                            // Reload page to update button states
                            window.location.reload();
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses permintaan.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // AJAX Handler untuk Auto Generate Matches
        document.querySelectorAll('form[action*="auto-generate"]').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                // Show confirmation with SweetAlert
                const result = await Swal.fire({
                    title: 'Auto Generate Draw?',
                    html: 'Apakah Anda yakin ingin membuat draw otomatis untuk round ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Generate! 🎲',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#10B981',
                    cancelButtonColor: '#6B7280'
                });

                if (!result.isConfirmed) return;

                // Show loading
                Swal.fire({
                    title: 'Generating...',
                    html: 'Sedang membuat matches... ⚡',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

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

                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil! 🎉',
                            html: `
                                                            <div style="font-size: 1.1em; line-height: 1.6;">
                                                                ${data.message}<br>
                                                                <strong style="color: #10B981; font-size: 1.5em; display: block; margin-top: 10px;">
                                                                    ${data.matches_created} Matches Created!
                                                                </strong>
                                                            </div>
                                                        `,
                            icon: 'success',
                            confirmButtonText: 'Cek Draw! 🔥',
                            confirmButtonColor: '#10B981',
                            showClass: {
                                popup: 'animate__animated animate__tada'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat generate matches.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // AJAX Handler untuk Auto Add Round
        document.querySelectorAll('form[action*="rounds/auto"]').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                // Show loading
                Swal.fire({
                    title: 'Creating Round...',
                    html: 'Sedang membuat round baru... ⚡',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

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

                    if (data.success) {
                        Swal.fire({
                            title: 'Round Berhasil Dibuat! 🎊',
                            html: `
                                                            <div style="font-size: 1.2em; line-height: 1.8;">
                                                                ${data.message}<br>
                                                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                                                            color: white; 
                                                                            padding: 15px 20px; 
                                                                            border-radius: 12px; 
                                                                            margin-top: 15px;
                                                                            font-weight: bold;
                                                                            font-size: 1.3em;
                                                                            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                                                    📋 ${data.round.name}
                                                                </div>
                                                            </div>
                                                        `,
                            icon: 'success',
                            confirmButtonText: 'Yeay! 🎉',
                            confirmButtonColor: '#8B5CF6',
                            showClass: {
                                popup: 'animate__animated animate__bounceIn'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat membuat round.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Auto Generate Match from Quick Action Card
        async function autoGenerateMatch() {
            const roundSelect = document.getElementById('match_round_select');
            const roundId = roundSelect.value;
            const roundName = roundSelect.options[roundSelect.selectedIndex].text;

            // Show confirmation with SweetAlert
            const result = await Swal.fire({
                title: 'Auto Generate Draw?',
                html: `Apakah Anda yakin ingin membuat draw otomatis untuk <strong>${roundName}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Generate! 🎲',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#9333EA',
                cancelButtonColor: '#6B7280'
            });

            if (!result.isConfirmed) return;

            // Show loading
            Swal.fire({
                title: 'Generating...',
                html: 'Sedang membuat matches... ⚡',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData();
            formData.append('round_id', roundId);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');

            try {
                const response = await fetch('<?php echo e(route("admin.matches.auto-generate")); ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil! 🎉',
                        html: `
                                <div style="font-size: 1.1em; line-height: 1.6;">
                                    ${data.message}<br>
                                    <strong style="color: #9333EA; font-size: 1.5em; display: block; margin-top: 10px;">
                                        ${data.matches_created} Matches Created!
                                    </strong>
                                </div>
                            `,
                        icon: 'success',
                        confirmButtonText: 'Cek Draw! 🔥',
                        confirmButtonColor: '#9333EA',
                        showClass: {
                            popup: 'animate__animated animate__tada'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan saat generate matches.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat generate matches.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    </script>

    <!-- Add Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\admin\tournaments\show.blade.php ENDPATH**/ ?>