

<?php $__env->startSection('title', 'Ballot Entry'); ?>

<?php $__env->startSection('content'); ?>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-black">Ballot Entry</h1>
            <p class="mt-2 text-sm text-black">Select a match to enter scores.</p>
        </div>
    </div>

    <!-- Tournament Selector -->
    <div class="mt-6">
        <form action="<?php echo e(route('admin.ballots.index')); ?>" method="GET" class="flex gap-4 items-end">
            <div>
                <label for="tournament_id" class="block text-sm font-medium leading-6 text-black">Tournament</label>
                <select id="tournament_id" name="tournament_id" onchange="this.form.submit()"
                    class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-black ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tournament->id); ?>" <?php echo e($selectedTournament && $selectedTournament->id == $tournament->id ? 'selected' : ''); ?>>
                            <?php echo e($tournament->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </form>
    </div>

    <div class="mt-8 flow-root">
        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <div class="font-semibold text-black text-lg"><?php echo e($match->round->name); ?></div>
                            <div class="text-xs text-gray-500">📍 <?php echo e($match->room->name ?? 'TBA'); ?></div>
                        </div>
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($match->result_status === 'confirmed' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-yellow-50 text-yellow-800 ring-yellow-600/20'); ?>">
                            <?php echo e(ucfirst($match->result_status ?? 'Pending')); ?>

                        </span>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-3 mb-3">
                        <div class="text-xs font-medium text-gray-500 mb-2">Matchup:</div>
                        <?php if($selectedTournament->format === 'british'): ?>
                            <div class="grid grid-cols-2 gap-1 text-sm">
                                <div><span class="text-blue-600 font-medium">OG:</span> <?php echo e($match->ogTeam->name); ?></div>
                                <div><span class="text-red-600 font-medium">OO:</span> <?php echo e($match->ooTeam->name); ?></div>
                                <div><span class="text-green-600 font-medium">CG:</span> <?php echo e($match->cgTeam->name); ?></div>
                                <div><span class="text-orange-600 font-medium">CO:</span> <?php echo e($match->coTeam->name); ?></div>
                            </div>
                        <?php else: ?>
                            <div class="space-y-1 text-sm">
                                <div><span class="text-blue-600 font-medium">Gov:</span> <?php echo e($match->govTeam->name); ?></div>
                                <div><span class="text-red-600 font-medium">Opp:</span> <?php echo e($match->oppTeam->name); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="text-xs text-gray-500 mb-3">
                        👨‍⚖️ <?php echo e($match->adjudicators->pluck('name')->join(', ') ?: 'No adjudicators'); ?>

                    </div>
                    <a href="<?php echo e(route('admin.ballots.create', $match->id)); ?>"
                        class="block w-full px-3 py-2 bg-indigo-600 text-white text-center text-sm font-medium rounded-lg hover:bg-indigo-700">
                        📝 Enter Ballot
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200 p-8 text-center">
                    <div class="text-4xl mb-2">📋</div>
                    <p class="text-gray-500">No matches found for this tournament.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block -mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-slate-300">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-black sm:pl-6">Round</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-black">Room</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-black">Matchup</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-black">Adjudicators</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-black">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Enter</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-black sm:pl-6"><?php echo e($match->round->name); ?></td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-black"><?php echo e($match->room->name ?? 'TBA'); ?></td>
                                    <td class="px-3 py-4 text-sm text-black">
                                        <?php if($selectedTournament->format === 'british'): ?>
                                            OG: <?php echo e($match->ogTeam->name); ?><br>
                                            OO: <?php echo e($match->ooTeam->name); ?><br>
                                            CG: <?php echo e($match->cgTeam->name); ?><br>
                                            CO: <?php echo e($match->coTeam->name); ?>

                                        <?php else: ?>
                                            Gov: <?php echo e($match->govTeam->name); ?><br>
                                            Opp: <?php echo e($match->oppTeam->name); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-black"><?php echo e($match->adjudicators->pluck('name')->join(', ')); ?></td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-black">
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($match->result_status === 'confirmed' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-yellow-50 text-yellow-800 ring-yellow-600/20'); ?>">
                                            <?php echo e(ucfirst($match->result_status ?? 'Pending')); ?>

                                        </span>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="<?php echo e(route('admin.ballots.create', $match->id)); ?>" class="text-indigo-600 hover:text-indigo-900">Enter Ballot<span class="sr-only">, <?php echo e($match->id); ?></span></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-black">
                                        No matches found for this tournament.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\admin\ballots\index.blade.php ENDPATH**/ ?>